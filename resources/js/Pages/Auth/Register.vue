<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    last_name: '',
    phone: '',
    parent_phone: '',
    gender: '',
    grade_id: null,
    governorate_id: null,
    type: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

// Define reactive variables for storing fetched data
const grades = ref([]);
const governorates = ref([]);

// Fetch grades and governorates data from backend
const fetchGradesAndGovernorates = async () => {
    try {
        const response = await axios.get('/api/grades');
        grades.value = response.data; // Assuming response.data is an array of grade objects

        const response2 = await axios.get('/api/governorates');
        governorates.value = response2.data; // Assuming response2.data is an array of governorate objects
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

// Fetch data when the component is mounted
onMounted(() => {
    fetchGradesAndGovernorates();
});

// Handle form submission
const submit = () => {
    form.post(route('register_jet'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('password', 'password_confirmation'); // Reset password fields on success
        },
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
            <!-- Name -->
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Last Name -->
            <div class="mt-4">
                <InputLabel for="last_name" value="Last Name" />
                <TextInput
                    id="last_name"
                    v-model="form.last_name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="family-name"
                />
                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <!-- Phone Number -->
            <div class="mt-4">
                <InputLabel for="phone" value="Phone Number" />
                <TextInput
                    id="phone"
                    v-model="form.phone"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="phone"
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <!-- Parent's Phone Number -->
            <div class="mt-4">
                <InputLabel for="parent_phone" value="Parent's Phone Number" />
                <TextInput
                    id="parent_phone"
                    v-model="form.parent_phone"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="phone"
                />
                <InputError class="mt-2" :message="form.errors.parent_phone" />
            </div>

            <!-- Gender -->
            <div class="mt-4">
                <InputLabel for="gender" value="Gender" />
                <select
                    id="gender"
                    v-model="form.gender"
                    class="mt-1 block w-full"
                    required
                >
                    <option value="" disabled>Select Gender</option>
                    <option value="ذكر">Male</option>
                    <option value="انثي">Female</option>
                </select>
                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <!-- Grade -->
            <div class="mt-4">
                <InputLabel for="grade_id" value="Grade" />
                <select
                    id="grade_id"
                    v-model="form.grade_id"
                    class="mt-1 block w-full"
                >
                    <option value="" disabled>Select Grade</option>
                    <option v-for="grade in grades" :key="grade.id" :value="grade.id">{{ grade.name }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.grade_id" />
            </div>

            <!-- Governorate -->
            <div class="mt-4">
                <InputLabel for="governorate_id" value="Governorate" />
                <select
                    id="governorate_id"
                    v-model="form.governorate_id"
                    class="mt-1 block w-full"
                >
                    <option value="" disabled>Select Governorate</option>
                    <option v-for="governorate in governorates" :key="governorate.id" :value="governorate.id">{{ governorate.name }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.governorate_id" />
            </div>

            <!-- Type -->
            <div class="mt-4">
                <InputLabel for="type" value="Type" />
                <select
                    id="type"
                    v-model="form.type"
                    class="mt-1 block w-full"
                    required
                >
                    <option value="" disabled>Select Type</option>
                    <option value="center">Center</option>
                    <option value="online">Online</option>
                </select>
                <InputError class="mt-2" :message="form.errors.type" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- Terms and Conditions -->
            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ms-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <!-- Register Button -->
            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Already registered?
                </Link>

                <PrimaryButton type="submit" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
