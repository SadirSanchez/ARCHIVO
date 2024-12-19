<template>
    <Head title="Inicio" />

    <AuthenticatedLayout>
        <template #header></template>

        <!-- Contenedor principal con fondo blanco -->
        <div class="py-12 bg-white">
            <div class="container">
                <!-- Contenedor de tarjetas -->
                <div class="row g-4 justify-content-center">
                  
                    <div class="col-md-4 col-sm-6" v-for="(archivo, index) in archivos" :key="index">
                        <div class="card shadow-lg border-0 rounded-3 overflow-hidden" style="max-width: 350px;">
                          
                            <div class="card-header bg-primary text-white p-3">
                                <h5 class="mb-0" style="font-weight: 500; font-size: 1.1rem;">{{ archivo.titulo }}</h5>
                            </div>
                           
                            <div class="ratio ratio-4x3 p-3" style="height: 120px; overflow: hidden;">
                                <iframe
                                    :src="archivo.documentos[archivo.documentos.length - 1].url"
                                    frameborder="0"
                                    class="rounded-2"
                                    style="width: 100%; height: 100%;"
                                ></iframe>
                            </div>
                            <div class="card-body p-3">
                                <p class="card-text text-muted" style="font-size: 0.9rem;">{{ archivo.descripcion }}</p>
                                
                                
                                <div class="dropdown">
                                    <button
                                        class="btn btn-outline-primary w-100 dropdown-toggle"
                                        type="button"
                                        id="dropdownMenuButton"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                       
                                        <li>
                                            <button
                                                class="dropdown-item"
                                                type="button"
                                                data-bs-toggle="modal"
                                                :data-bs-target="'#modal-' + index"
                                            >
                                                Ver Documentos
                                            </button>
                                        </li>
                                       
                                        <li>
                                            <label class="dropdown-item mb-0" style="cursor: pointer;">
                                                Subir Documento
                                                <input
                                                    type="file"
                                                    class="d-none"
                                                    @change="(event) => handleFileUpload(event, index)"
                                                />
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        
                        <div
                            class="modal fade"
                            :id="'modal-' + index"
                            tabindex="-1"
                            aria-labelledby="modalLabel"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">{{ archivo.titulo }}</h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"
                                        ></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group">
                                            <li
                                                v-for="(doc, docIndex) in archivo.documentos"
                                                :key="docIndex"
                                                class="list-group-item d-flex justify-content-between align-items-center"
                                            >
                                                <span>{{ doc.nombre }}</span>
                                                <a
                                                    :href="doc.url"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="btn btn-outline-primary btn-sm"
                                                >
                                                    Abrir
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                        >
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const archivos = ref([
    { 
        titulo: 'POLITICA', 
        documentos: [{ nombre: 'Documento Original', url: '/storage/documents/info1.pdf' }] 
    },
    { 
        titulo: 'PGD', 
        documentos: [{ nombre: 'Documento Original', url: '' }]
    },
    { 
        titulo: 'TRD', 
        documentos: [{ nombre: 'Documento Original', url: '' }] 
    },
    { 
        titulo: 'PINAR', 
        documentos: [{ nombre: 'Documento Original', url: '' }] 
    },
    { 
        titulo: 'INVENTARIO', 
        documentos: [{ nombre: 'Documento Original', url: '' }] 
    },
    { 
        titulo: 'SIC', 
        documentos: [{ nombre: 'Documento Original', url: '' }] 
    },
]);

function handleFileUpload(event, index) {
    const file = event.target.files[0];
    if (file) {
        const newUrl = URL.createObjectURL(file);
        const newDocumento = { nombre: file.name, url: newUrl };
        archivos.value[index].documentos.push(newDocumento);
        console.log(`Archivo "${file.name}" subido para la tarjeta "${archivos.value[index].titulo}".`);
    }
}
</script>

<style>
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 300px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    height: 210px; 
    margin: 0 auto; 
}

.card:hover {
    transform: scale(1.05); 
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.ratio {
    overflow: hidden;
    background-color: #ffffff; 
    border-radius: 8px; 
}

iframe {
    display: block;
    border: none;
}

.card-header {
    background-color: #007bff; 
    border-bottom: 2px solid rgba(0, 0, 0, 0.1); 
}

.modal .list-group-item {
    font-size: 0.9rem;
    font-weight: 500;
}
</style>
