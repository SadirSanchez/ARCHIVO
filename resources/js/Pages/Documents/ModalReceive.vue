<template>
    <super-modal
        ref="modalReceive"
        title="Recepcionar documentos"
        key-modal="modalReceive"
        accept-title="Guardar"
        @accept="action === 'edit' ? Update() : submit()"
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
                            <label for="">Tiempo de retención (*)</label>
                            <input
                                v-model="FormUser.retentionTime"
                                class="form-control form-control-lg"
                                type="text"
                            />
                        </div>
                    </div>
                </div>

                <div class="row g-3">
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
                </div>

                <div class="row g-3">
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
                </div>
            </form>
        </template>
    </super-modal>
</template>

<script setup>
import SuperModal from "@/Components/Modals/SuperModal.vue";
import { ref, reactive, defineExpose } from "vue";

const modalReceive = ref(null);

const FormUser = reactive({
    originDependency: null,
    typeDocument: null,
    name: null,
    retentionTime: null,
    dateElaboration: null,
    totalInventory: null,
    physicalLocation: null,
});

function openModal() {
    modalReceive.value.open();
}

function CloseModal() {
    modalReceive.value.close();
}

defineExpose({ openModal, CloseModal });
</script>
