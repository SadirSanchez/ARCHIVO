<template>
    <super-modal
        ref="modalReceive"
        title="Recepcionar documentos"
        key-modal="modalReceive"
        accept-title="Guardar"
        @accept="saveDocuement"
        :is-loading="isLoading"
    >
        <template #body>
            <form>
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Dependencia productora (*)</label>
                            <select
                                v-model="FormUser.originDependency"
                                class="form-control form-control-lg"
                            >
                                <option>Seleccionar</option>
                                <option value="Despacho">Despacho</option>
                                <option value="Gobierno">Gobierno</option>
                                <option value="General">General</option>
                                <option value="Hacienda">Hacienda</option>
                                <option value="Planeación">Planeación</option>
                                <option value="Educación">Educación</option>
                                <option value="Salud">Salud</option>
                                <option value="Transito">Transito</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Tipo de documento (*)</label>
                            <select
                                v-model="FormUser.typeDocument"
                                class="form-control form-control-lg"
                            >
                                <option>Seleccionar</option>
                                <option value="Acta">Acta</option>
                                <option value="Decreto">Decreto</option>
                                <option value="Resolución">Resolución</option>
                                <option value="HistoriaLaboral">
                                    Historia Laboral
                                </option>
                                <option value="Certificado">Certificado</option>
                                <option value="Acuerdo">Acuerdo</option>
                                <option value="Licencia">Licencia</option>
                                <option value="Contrato">Contrato</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Nombre (*)</label>
                            <input
                                v-model="FormUser.name"
                                class="form-control form-control-lg"
                                type="text"
                            />
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Número de documento (*)</label>
                            <input
                                class="form-control form-control-lg"
                                type="number"
                                v-model="FormUser.documentNumber"
                            />
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Años de retención (*)</label>
                            <input
                                v-model="FormUser.retentionTime"
                                class="form-control form-control-lg"
                                type="number"
                            />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Fecha de elaboración (*)</label>
                            <input
                                v-model="FormUser.dateElaboration"
                                class="form-control form-control-lg"
                                type="date"
                            />
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Inventario documental(*)</label>
                            <input
                                v-model="FormUser.totalInventory"
                                class="form-control form-control-lg"
                                type="text"
                            />
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="pdfFile">Subir archivo PDF</label>
                            <input
                                type="file"
                                class="form-control form-control-lg"
                                @change="handleFileUpload"
                                accept=".pdf"
                            />
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="">Ubicación física(*)</label>
                        <textarea
                            v-model="FormUser.physicalLocation"
                            class="form-control form-control-lg"
                            type="text"
                        >
                        </textarea>
                    </div>
                </div>
            </form>
        </template>
    </super-modal>
    <Alerts
        v-if="aalert.open"
        :Title="aalert.Title"
        :Body="aalert.Body"
        :Type="aalert.Type"
        :Redirect="aalert.Redirect"
        :RedirectParams="aalert.RedirectParams"
    />
</template>

<script setup>
import Alerts from "@/Components/Modals/Alerts.vue";
import SuperModal from "@/Components/Modals/SuperModal.vue";
import axios from "axios";
import { ref, reactive, defineExpose } from "vue";

const modalReceive = ref(null);

const aalert = reactive({
    open: false,
    Title: null,
    Type: null,
    Redirect: null,
    Body: null,
});

const FormUser = reactive({
    originDependency: null,
    typeDocument: null,
    name: null,
    documentNumber: null,
    retentionTime: null,
    dateElaboration: null,
    totalInventory: null,
    physicalLocation: null,
    pdfFile: null,
});

function handleFileUpload(event) {
    FormUser.pdfFile = event.target.files[0];
}

function openModal() {
    FormUser.originDependency = "",
    FormUser.typeDocument = "",
    FormUser.name = "",
    FormUser.documentNumber = "",
    FormUser.retentionTime = "",
    FormUser.dateElaboration = "",
    FormUser.totalInventory = "",
    FormUser.physicalLocation = "",
    FormUser.pdfFile = "",
    modalReceive.value.open();
}

function CloseModal() {
    modalReceive.value.close();
}

const saveDocuement = async () => {
    aalert.open = false;
    const formData = new FormData();
    formData.append("originDependency", FormUser.originDependency);
    formData.append("typeDocument", FormUser.typeDocument);
    formData.append("name", FormUser.name);
    formData.append("documentNumber", FormUser.documentNumber );
    formData.append("retentionTime", FormUser.retentionTime);
    formData.append("dateElaboration", FormUser.dateElaboration);
    formData.append("totalInventory", FormUser.totalInventory);
    formData.append("physicalLocation", FormUser.physicalLocation);

    if (FormUser.pdfFile) {
        formData.append("pdfFile", FormUser.pdfFile);
    }

    try {
        const res = await axios.post(route("documents.store"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        console.log("Respuesta de éxito:", res);

        aalert.open = true;
        aalert.Title = "¡Bien hecho!";
        aalert.Body = "Se registró el documento correctamente.";
        aalert.Type = "success";
        aalert.Redirect = "documents.index";
    } catch (error) {
        console.log("Error al guardar documento:", error);
        alert("Hubo un error al guardar el documento");
    }
};

defineExpose({ open, openModal, CloseModal });
</script>
