<template>
    <Head title="Documents" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Documentos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Menú de opciones -->
                        <div class="flex space-x-4">
                            <button @click="openReceiveModal" class="btn btn-primary">
                                Recibir
                            </button>
                            <button @click="verDocumento" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Ver
                            </button>
                            <button @click="editarDocumento" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Editar
                            </button>
                            <button @click="eliminarDocumento" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Eliminar
                            </button>
                        </div>

                        <!-- Aquí puedes agregar una tabla o lista de documentos -->
                        <div class="mt-6">
                            <table class="min-w-full bg-white">
                                <!-- Encabezado de la tabla -->
                                <thead>
                                    <tr>
                                        <th class="w-1/3 px-4 py-2">Nombre del Documento</th>
                                        <th class="w-1/3 px-4 py-2">Fecha de Creación</th>
                                        <th class="w-1/3 px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <!-- Cuerpo de la tabla -->
                                <tbody>
                                    <!-- Aquí agregarías el ciclo para mostrar los documentos -->
                                    <tr v-for="documento in documentos" :key="documento.id">
                                        <td class="border px-4 py-2">{{ documento.nombre }}</td>
                                        <td class="border px-4 py-2">{{ documento.fecha_creacion }}</td>
                                        <td class="border px-4 py-2">
                                            <button @click="verDocumento(documento.id)" class="bg-green-500 text-white px-2 py-1 rounded">Ver</button>
                                            <button @click="editarDocumento(documento.id)" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</button>
                                            <button @click="eliminarDocumento(documento.id)" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ModalReceive ref="modalReceive" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ModalReceive from './ModalReceive.vue';

const modalReceive = ref(null);

const openReceiveModal = () => {
    if (modalReceive.value) {
        modalReceive.value.openModal();
    }
};


const documentos = ref([
    { id: 1, nombre: 'Documento 1', fecha_creacion: '2023-01-01' },
    { id: 2, nombre: 'Documento 2', fecha_creacion: '2023-02-01' },
    // Aquí puedes agregar más documentos o hacer la solicitud para obtenerlos desde el servidor.
]);

// Funciones para manejar las acciones del CRUD
const recibirDocumento = () => {
    // Lógica para recibir un nuevo documento
    console.log('Recibiendo documento');
};

const verDocumento = (id) => {
    // Lógica para ver el detalle de un documento
    console.log('Viendo documento', id);
};

const editarDocumento = (id) => {
    // Lógica para editar un documento
    console.log('Editando documento', id);
};

const eliminarDocumento = (id) => {
    // Lógica para eliminar un documento
    if (confirm('¿Estás seguro de eliminar este documento?')) {
        console.log('Eliminando documento', id);
    }
};


</script>
