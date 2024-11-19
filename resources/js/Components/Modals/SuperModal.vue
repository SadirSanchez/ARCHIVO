<template>
    <div
        class="modal fade"
        :class="{ show: isOpen }"
        :style="{ display: isOpen ? 'block' : 'none' }"
        @click.self="closeClickOut ? close() : null"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modal-title"
        aria-hidden="!isOpen"
    >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div :class="classHeader" style="border-bottom: none">
                    <h5
                        class="modal-title"
                        id="modal-title"
                        v-text="title"
                    ></h5>
                    <button
                        v-if="!hideCancel"
                        type="button"
                        class="btn-close"
                        aria-label="Close"
                        @click="close"
                    ></button>
                </div>

                <div
                    class="modal-body pd-20"
                    :class="{ scrollable: heightModal !== 'auto' }"
                >
                    <slot name="body"></slot>
                </div>

                <div class="modal-footer" v-if="!hideFooter">
                    <slot name="footer">
                        <button
                            v-if="!hideCancel"
                            class="btn btn-secondary"
                            @click="close"
                        >
                            {{ props.cancelTitle }}
                        </button>
                        <button
                            v-if="!hideAccept"
                            class="btn btn-primary"
                            :disabled="dissableAccept"
                            @click="!dissableAccept ? accept() : null"
                        >
                            {{ props.acceptTitle }}
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, ref, defineEmits, onMounted, defineExpose } from "vue";

const emit = defineEmits(["accept", "cancel"]);
const props = defineProps({
    title: { required: true, type: String, default: "Modal Title" },
    classHeader: {
        type: String,
        default: "modal-header bg-white text-dark",
    },
    keyModal: {
        required: true,
        type: String,
        default: "SuperModal",
    },
    heightModal: {
        type: String,
        default: "100%",
    },
    closeClickOut: {
        type: Boolean,
        default: false,
    },
    hideFooter: {
        type: Boolean,
        default: false,
    },
    dissableAccept: {
        type: Boolean,
        default: false,
    },
    hideAccept: {
        type: Boolean,
        default: false,
    },
    hideCancel: {
        type: Boolean,
        default: false,
    },
    acceptTitle: {
        type: String,
        default: "Aceptar",
    },
    cancelTitle: {
        type: String,
        default: "Cancelar",
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
});

const isOpen = ref(false);

onMounted(() => {
    // Configura la altura del modal si no es 'auto'
    if (props.heightModal !== "auto") {
        const rootElement = document.documentElement;
        rootElement.style.setProperty("--heightModal", props.heightModal);
    }
});

const open = () => {
    isOpen.value = true;
    document.body.classList.add("modal-open"); // Para ocultar el scroll del body
};

const close = () => {
    isOpen.value = false;
    document.body.classList.remove("modal-open"); // Para retornar el scroll del body
    emit("cancel");
};

const accept = () => {
    emit("accept");
    close(); // Cerrar el modal al aceptar
};

defineExpose({ open, close });
</script>

<style scoped>
.scrollable {
    max-height: 450px;
    overflow-y: auto;
}
</style>
