<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $gender = $this->faker->randomElement(['male', 'female']);

    $faker = \Faker\Factory::create('es_ES');

    $firstName = $gender === 'male'
        ? $faker->firstNameMale
        : $faker->firstNameFemale;

    $lastName = $faker->lastName;

    $fullName = $firstName . ' ' . $lastName;

    $birthdate = $faker
        ->dateTimeBetween('1974-01-01', '2004-12-31')
        ->format('Y-m-d');

    // Documento (será también el nombre de la imagen)
    $document = $faker->unique()->numberBetween(100000000, 999999999);

    // Generar email combinando nombre + apellido
    $email = strtolower($firstName . '.' . $lastName) . '@gmail.com';

    // Limpiar tildes y espacios (opcional pero recomendado)
    $email = Str::ascii($email);

    // Intenta obtener imagen del API randomuser.me con manejo de errores
    $fileName = $document . '.jpg';
    $photoPath = 'photos/' . $fileName;

    try {
        $response = Http::timeout(10)->get("https://randomuser.me/api/", [
            'gender' => $gender,
            'nat' => 'us',
            'inc' => 'picture',
        ]);

        // Validar que la respuesta sea exitosa y tenga datos
        if ($response->successful() && !empty($response->json()['results'])) {
            $data = $response->json()['results'][0];
            
            // Verificar que existan los campos necesarios
            if (isset($data['picture']['large'])) {
                $imageUrl = $data['picture']['large'];

                // Guardar imagen
                $directory = public_path('photos');
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }

                $imageContent = file_get_contents($imageUrl);
                if ($imageContent !== false) {
                    File::put($directory . '/' . $fileName, $imageContent);
                } else {
                    // Si la descarga falla, usar imagen por defecto
                    $this->createDefaultPhoto($directory, $fileName);
                }
            } else {
                // Si no están los campos esperados, usar imagen por defecto
                $this->createDefaultPhoto(public_path('photos'), $fileName);
            }
        } else {
            // Si la respuesta no es exitosa o no hay datos, usar imagen por defecto
            $this->createDefaultPhoto(public_path('photos'), $fileName);
        }
    } catch (\Exception $e) {
        // En caso de cualquier excepción (timeout, conexión, etc), usar imagen por defecto
        $this->createDefaultPhoto(public_path('photos'), $fileName);
    }

    return [
        'document' => $document,
        'fullname' => $fullName,
        'gender' => ucfirst($gender),
        'birthdate' => $birthdate,
        'photo' => 'photos/' . $fileName,
        'phone' => $faker->phoneNumber(),
        'email' => $email,
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'active' => true,
        'role' => 'Customer',
        'remember_token' => Str::random(10),
    ];
}


    /**
     * Crea una imagen de placeholder por defecto cuando la API falla
     */
    private function createDefaultPhoto($directory, $fileName): void
    {
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Crear un PNG simple de 200x200 con fondo gris y texto
        $image = imagecreatetruecolor(200, 200);
        $bgColor = imagecolorallocate($image, 200, 200, 200);
        $textColor = imagecolorallocate($image, 100, 100, 100);
        
        imagefill($image, 0, 0, $bgColor);
        imagestring($image, 2, 60, 95, 'No Photo', $textColor);
        
        imagejpeg($image, $directory . '/' . $fileName, 90);
        imagedestroy($image);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}