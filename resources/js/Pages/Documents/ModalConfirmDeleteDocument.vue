<template>
    <super-modal
        ref="mdlConfirmDeleteDocument"
        key-modal="mdlConfirmDeleteDocument"
        title="Eliminar documento"
        accept-title="Si,eliminar"
        heightModal="auto"
        @accept="confirmDelete()"
    >
        <template #body>
            <div class="row mt-2">
                <div class="col-12">
                    <p>¿Seguro que deseas eliminar este documento?</p>
                </div>
            </div>
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
import { ref, defineExpose, reactive } from "vue";
import SuperModal from "@/Components/Modals/SuperModal.vue";
import axios from "axios";
import Alerts from "@/Components/Modals/Alerts.vue";

const mdlConfirmDeleteDocument = ref(null);
const documentToDelete = ref();

const aalert = reactive({
    open: false,
    Title: null,
    Type: null,
    Redirect: null,
    Body: null,
});

function openModalDelete(document) {
    documentToDelete.value = document.id;
    mdlConfirmDeleteDocument.value.open(document);
}

const confirmDelete = async () => {
    aalert.open = false;
    await axios
        .put(route("documents.delete", {
                id: documentToDelete.value,
            })
        ).then((res) => {
            aalert.open = true;
            aalert.Title = "¡Bien hecho!";
            aalert.Body = "Se eliminó el documento correctamente.";
            aalert.Type = "success";
            aalert.Redirect = "documents.index";
        });
};

defineExpose({ open, openModalDelete });
</script>
