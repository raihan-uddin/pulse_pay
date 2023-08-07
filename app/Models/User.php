<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phonecode',
        'phone_number',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        // Eloquent event: Creating
        static::creating(function ($user) {

            try {
                // Begin a database transaction
                DB::beginTransaction();
                // Set the hashed password
                $user->password = Hash::make($user->password);

                // Set the username by concatenating phonecode and phone_number
                $user->username = $user->phonecode.$user->phone_number;
                $user->status = 'active';
                $user->remember_token = Str::random(10);

                // Validate the phonecode before proceeding
                $validator = Validator::make(['phonecode' => $user->phonecode], [
                    'phonecode' => 'exists:countries,phonecode',
                ]);

                if ($validator->fails()) {
                    // Throw a validation exception with an appropriate error message
                    throw new \Illuminate\Validation\ValidationException(
                        $validator,
                        response()->json([
                            'success' => false,
                            'message' => 'Country not found.',
                        ], 422)
                    );
                }

                // Get the country information based on the phonecode
                $country = Country::where('phonecode', $user->phonecode)->first();

                $user->country_code = $country->country_code;
                $user->currency_code = $country->currency_code;

                // Commit the transaction if everything is successful
                DB::commit();
            } catch (\Exception $e) {
                // Log the exception
                Log::error('Error creating user: '.$e->getMessage());
                // If an exception occurs, roll back the transaction to undo the changes
                DB::rollback();

                // Rethrow the exception to be caught by the outer try-catch block or Laravel's exception handler
                throw $e;
            }
        });
    }
}
