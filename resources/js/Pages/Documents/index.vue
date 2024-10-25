<template>
    <Head title="Documents" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Documentos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Menú de opciones -->
                        <div class="flex space-x-4">
                            <button
                                @click="openReceiveModal"
                                class="btn btn-primary"
                            >
                                Recibir
                            </button>
                            <button
                                @click="verDocumento"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Ver
                            </button>
                            <button
                                @click="editarDocumento"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Editar
                            </button>
                            <button
                                @click="eliminarDocumento"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Eliminar
                            </button>
                        </div>

                        <!-- Aquí puedes agregar una tabla o lista de documentos -->
                        <div
                            class="ag-theme-quartz mt-6"
                            style="height: 400px; width: 100%"
                        >
                            <AgGridVue
                                class="ag-theme-quartz"
                                :columnDefs="colDefs"
                                :rowData="documents"
                                rowSelection="single"
                                :defaultColDef="defaultColDef"
                                style="width: 100%; height: 100%"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ModalReceive ref="modalReceive" />
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ModalReceive from "./ModalReceive.vue";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";
import { AgGridVue } from "ag-grid-vue3";

const modalReceive = ref(null);
const documents = ref("");

const colDefs = ref([
    { field: "name", headerName: "Nombre" },
    { field: "typeDocument", headerName: "Tipo de documento" },
    { field: "documentNumber", headerName: "Número de documento" },
    { field: "dateElaboration", headerName: "Fecha documento" },
    { field: "originDependency", headerName: "Dependencia productora" },
    
]);

const openReceiveModal = () => {
    if (modalReceive.value) {
        modalReceive.value.openModal();
    }
};

const getDocuments = async () => {
    await axios.get(route("documents.getDocuments"), {}).then((res) => {
        documents.value = res.data;
    });
};

onMounted(() => {
    getDocuments();
});

const documentos = ref([
    { id: 1, nombre: "Documento 1", fecha_creacion: "2023-01-01" },
    { id: 2, nombre: "Documento 2", fecha_creacion: "2023-02-01" },
    // Aquí puedes agregar más documentos o hacer la solicitud para obtenerlos desde el servidor.
]);

// Funciones para manejar las acciones del CRUD
const recibirDocumento = () => {
    // Lógica para recibir un nuevo documento
    console.log("Recibiendo documento");
};

const verDocumento = (id) => {
    // Lógica para ver el detalle de un documento
    console.log("Viendo documento", id);
};

const editarDocumento = (id) => {
    // Lógica para editar un documento
    console.log("Editando documento", id);
};

const eliminarDocumento = (id) => {
    // Lógica para eliminar un documento
    if (confirm("¿Estás seguro de eliminar este documento?")) {
        console.log("Eliminando documento", id);
    }
};
</script>
