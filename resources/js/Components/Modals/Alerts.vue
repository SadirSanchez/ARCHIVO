<template>
  <!-- MODAL ALERT MESSAGE -->
  <div
      class="modal fade"
      id="ModalAlert_"
      tabindex="-1"
      aria-labelledby="alertModalLabel"
      aria-hidden="true"
      ref="modalAlert"
  >
      <div
          class="modal-dialog modal-dialog-centered text-center"
          role="document"
      >
          <div class="modal-content tx-size-sm">
              <div class="modal-body text-center p-4">
                  <div class="row justify-content-center">
                      <img
                          v-if="Type === 'success'"
                          src="/assets/images/gif/68994-success.gif"
                          style="max-height: 200px"
                          alt="Success"
                      />
                      <img
                          v-if="Type === 'error'"
                          src="/assets/images/gif/14651-error-animation.gif"
                          style="max-height: 200px"
                          alt="Error"
                      />
                      <img
                          v-if="Type === 'warning'"
                          src="/assets/images/gif/84965-warning-yellow.gif"
                          style="max-height: 200px"
                          alt="Warning"
                      />
                  </div>

                  <h2
                      :class="
                          Type === 'success'
                              ? 'text-primary'
                              : Type === 'error'
                              ? 'text-danger'
                              : 'text-warning'
                      "
                      class="tx-semibold"
                  >
                      {{ Title }}
                  </h2>

                  <p class="mg-b-20 mg-x-20 h5">{{ Body }}</p>

                  <button
                      @click="RedirectTo"
                      aria-label="Close"
                      :class="
                          Type === 'success'
                              ? 'btn btn-info'
                              : Type === 'error'
                              ? 'btn btn-danger'
                              : 'btn btn-warning'
                      "
                      class="pd-x-25"
                      type="button"
                  >
                      Aceptar
                  </button>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import { Modal } from 'bootstrap'; // Importar la clase Modal desde Bootstrap

export default {
    name: "Alert",
    props: {
        Title: {
            type: String,
            required: true,
        },
        Body: {
            type: String,
            required: true,
        },
        Type: {
            type: String,
            required: true,
        },
        Redirect: {
            type: String,
            required: false,
            default: null,
        },
        RedirectParams: {
            type: Object,
            required: false,
            default: null,
        },
    },

    emits: ["AlertOk"],

    mounted() {
        // Inicializar el modal usando la API nativa de Bootstrap 5
        const modalElement = this.$refs.modalAlert;
        this.modalInstance = new Modal(modalElement, {
            backdrop: "static",  // Impedir el cierre al hacer clic fuera
            keyboard: false      // Desactivar el cierre con la tecla Esc
        });

        // Mostrar el modal
        this.modalInstance.show();
    },

    methods: {
        RedirectTo() {
            if (this.Redirect) {
                if (this.RedirectParams) {
                    this.$inertia.get(
                        route(this.Redirect, this.RedirectParams)
                    );
                } else {
                    this.$inertia.get(route(this.Redirect));
                }
            }

            this.$emit("AlertOk", true);

            // Cierra el modal utilizando la API de Bootstrap 5
            this.modalInstance.hide();

            // Elimina el backdrop cuando se oculta el modal
            this.modalInstance._element.addEventListener('hidden.bs.modal', () => {
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(backdrop => backdrop.remove());
            });
        },
    },
};
</script>

