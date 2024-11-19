<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mb-4">
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" id="role" class="block mt-1 w-full" required onchange="showRoleFields()">
                <option value="">Select Role</option>
                <option value="doctor">Doctor</option>
                <option value="assistant">Assistant</option>
                <option value="receptionist">Receptionist</option>
                <option value="patient">Patient</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Doctor Specific Fields -->
        <div id="doctor-fields" class="hidden">
            <div>
                <x-input-label for="specialization" :value="__('Specialization')" />
                <x-text-input id="specialization" class="block mt-1 w-full" type="text" name="specialization" :value="old('specialization')" />
                <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="section_name" :value="__('Section Name')" />
                <select id="section_name" name="section_name" class="block mt-1 w-full">
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->SectionID }}">{{ $section->Name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('section_name')" class="mt-2" />
            </div>
        </div>

        <!-- Assistant Specific Fields -->
        <div id="assistant-fields" class="hidden">
            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="section_name" :value="__('Section Name')" />
                <select id="section_name" name="section_name" class="block mt-1 w-full">
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->SectionID }}">{{ $section->Name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('section_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="doctor_name" :value="__('Doctor Name')" />
                <select id="doctor_name" name="doctor_name" class="block mt-1 w-full">
                    <option value="">Select Doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->DoctorID }}">{{ $doctor->Name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('doctor_name')" class="mt-2" />
            </div>
        </div>

        <!-- Patient Specific Fields -->
        <div id="patient-fields" class="hidden">
            <div class="mt-4">
                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <!-- Receptionist Specific Fields -->
        <div id="receptionist-fields" class="hidden">
            <div class="mt-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function showRoleFields() {
            const role = document.getElementById("role").value;
            document.getElementById("doctor-fields").classList.add("hidden");
            document.getElementById("patient-fields").classList.add("hidden");
            document.getElementById("assistant-fields").classList.add("hidden");
            document.getElementById("receptionist-fields").classList.add("hidden");

            if (role === "doctor") {
                document.getElementById("doctor-fields").classList.remove("hidden");
            } else if (role === "assistant") {
                document.getElementById("assistant-fields").classList.remove("hidden");
            } else if (role === "patient") {
                document.getElementById("patient-fields").classList.remove("hidden");
            } else if (role === "receptionist") {
                document.getElementById("receptionist-fields").classList.remove("hidden");
            }
        }
    </script>
</x-guest-layout>
