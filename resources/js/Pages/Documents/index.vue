<template>
    <Head title="Documents" />

    <AuthenticatedLayout>
        <div class="py-6 bg-white">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 bg-white border-b border-gray-200">
                        <!-- Menú de opciones -->
                        <div class="flex justify-between items-center">
                            <h2
                                class="font-semibold text-xl text-gray-800 leading-tight"
                            >
                                Sistema de Gestión de Documento
                            </h2>
                            <button
                                @click="openReceiveModal"
                                class="btn btn-primary"
                            >
                                Recepcionar Documentos
                            </button>
                        </div>

                        <!-- Tabla de documentos -->
                        <div
                            class="ag-theme-quartz mt-3"
                            style="height: 350px; width: 100%"
                        >
                            <AgGridVue
                                class="ag-theme-quartz"
                                :columnDefs="colDefs"
                                :rowData="documents"
                                rowSelection="single"
                                :defaultColDef="defaultColDef"
                                style="width: 100%; height: 100%"
                                :localeText="localeText"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ModalReceive ref="modalReceive" />
        <ModalConfirmDeleteDocument ref="mdlConfirmDeleteDocument" />
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
import { localeText } from "@/Helpers/AgGridLocaleText.ts";
import ModalConfirmDeleteDocument from "./ModalConfirmDeleteDocument.vue";

const modalReceive = ref(null);
const documents = ref("");
const mdlConfirmDeleteDocument = ref(null);

const colDefs = ref([
    {
        field: "name",
        headerName: "Nombre",
        minWidth: 250,
        checkboxSelection: (params) => !!params.data,
    },
    { field: "typeDocument", headerName: "Tipo de documento", minWidth: 200 },
    {
        field: "documentNumber",
        headerName: "Número de documento",
        minWidth: 235,
    },
    { field: "dateElaboration", headerName: "Fecha documento", minWidth: 250 },
    {
        field: "originDependency",
        headerName: "Dependencia productora",
        minWidth: 250,
    },
    {
        headerName: "Acciones",
        minWidth: 100,
        cellRenderer: (params) => {
            const container = document.createElement("div");
            container.classList.add("d-flex");

            const viewButton = document.createElement("button");
            viewButton.innerHTML = '<i class="fa-regular fa-eye"></i>';
            viewButton.classList.add("btn", "btn-sm", "btn-info");
            viewButton.setAttribute("title", "Ver Documento");
            viewButton.onclick = () => showDocument(params.data);
            container.appendChild(viewButton);

            const editButton = document.createElement("button");
            editButton.innerHTML = '<i class="fa-regular fa-pen-to-square"></i>';
            editButton.classList.add("btn", "btn-sm", "btn-warning");
            editButton.setAttribute("title", "Editar Documento");
            editButton.onclick = () => openReceiveModal(params.data);
            container.appendChild(editButton);

            const deleteButton = document.createElement("button");
            deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
            deleteButton.classList.add("btn", "btn-sm", "btn-danger");
            deleteButton.setAttribute("title", "Eliminar Documento");
            deleteButton.onclick = () => openDeleteDocument(params.data);
            container.appendChild(deleteButton);

            return container;
        },
    },
]);

const defaultColDef = {
    filter: true,
    sortable: true,
    resizable: true,
};

const openReceiveModal = (document) => {
    if (modalReceive.value) {
        modalReceive.value.openModal(document);
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

const showDocument = (document) => {
    const fullUrl = `http://127.0.0.1:8000/storage/${document.pdf_file_path}`;
    window.open(fullUrl, "_blank");
};

const openDeleteDocument = (document) => {
    if (mdlConfirmDeleteDocument.value) {
        mdlConfirmDeleteDocument.value.openModalDelete(document);
    }
};
</script>
