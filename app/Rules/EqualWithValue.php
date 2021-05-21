<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EqualWithValue implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($password_value)
    {
        $this->password_value = $password_value;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $password_confirm_value
     * @return bool
     */
    public function passes($attribute, $password_confirm_value)
    {
        return $password_confirm_value === $this->password_value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'パスワードと一致しません';
    }
}
