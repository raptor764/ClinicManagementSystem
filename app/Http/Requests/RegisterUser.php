<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
{
    public function rules()
    {
        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . $this->getModelClass($this->role), // Adjusted for specific user tables
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:doctor,assistant,receptionist,patient',
        ];

        // Role-specific validation rules
        switch ($this->role) {
            case 'doctor':
                $rules['specialization'] = 'required|string|max:255';
                $rules['phone'] = 'required|string|max:15'; // Assuming a phone number format
                $rules['section_name'] = 'required|string|max:255';
                break;

            case 'patient':
                $rules['date_of_birth'] = 'required|date';
                $rules['address'] = 'required|string|max:255';
                $rules['phone'] = 'required|string|max:15'; // Assuming a phone number format
                break;

            case 'assistant':
                $rules['phone'] = 'required|string|max:15'; // Assuming a phone number format
                $rules['section_name'] = 'required|string|max:255';
                $rules['doctor_name'] = 'required|string|max:255'; // Assuming you want to validate the doctor's name
                break;

            case 'receptionist':
                $rules['phone'] = 'required|string|max:15'; // Assuming a phone number format
                break;
        }

        return $rules;
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'The password field is required.',
            'role.required' => 'You must select a role.',
            // Add other custom messages as needed
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Adjust authorization as necessary
    }

    /**
     * Get the model class for user role.
     *
     * @return string
     */
    private function getModelClass($role)
    {
        switch ($role) {
            case 'doctor':
                return 'doctors';
            case 'assistant':
                return 'assistants';
            case 'receptionist':
                return 'receptionists';
            case 'patient':
                return 'patients';
            default:
                return 'users'; // Default case
        }
    }
}
