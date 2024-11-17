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
</template>
<script setup>
import { ref, defineExpose } from "vue";
import SuperModal from "@/Components/Modals/SuperModal.vue";

const mdlConfirmDeleteDocument = ref(null);

function openModalDelete(document) {
    mdlConfirmDeleteDocument.value.open();
}

defineExpose({ open, openModalDelete });
</script>
