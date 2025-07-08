<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

// Extraer datos del servidor (edición de usuario)
const { props } = usePage();
const user = props.user || null;

// Inicializar el formulario
const form = useForm({
    name: user ? user.name : "",
    email: user ? user.email : "",
    password: "",
    password_confirmation: "",
    role: user ? user.role : "",
});

// Captura mensajes de éxito de la sesión
const successMessage = usePage().props.flash?.success;

// Manejar el envío del formulario
const submit = () => {
    if (user) {
        // Editar usuario
        form.put(route("users.update", user.id));
    } else {
        // Crear nuevo usuario
        form.post(route("users.register.store"), {
            onFinish: () => form.reset("password", "password_confirmation"),
        });
    }
};
</script>

<template>
    <GuestLayout>
        <Head :title="user ? 'Editar Usuario' : 'Registrar Usuario'" />

        <!-- Mensaje de éxito -->
        <div v-if="successMessage" class="mb-4 text-sm text-green-600">
            {{ successMessage }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nombre" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4" v-if="!user">
                <InputLabel for="password" value="Contraseña" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4" v-if="!user">
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar Contraseña"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4" v-if="!user">
                <InputLabel for="userRol" value="Rol del usuario" />

                <select
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    v-model="form.role"
                    id="userRol"
                    required
                >
                    <option value="" disabled selected >Seleccione un rol</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>

                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('users.index')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Regresar
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ user ? "Guardar Cambios" : "Registrar" }}
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
