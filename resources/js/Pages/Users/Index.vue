<template>
  <AuthenticatedLayout>
    <!-- Contenedor principal ajustado -->
    <div class="flex flex-col items-center justify-start bg-gray-50">
      <div class="p-6 bg-white rounded-lg shadow-lg max-w-4xl w-full mt-6">
        <!-- Título centrado -->
        <h1 class="text-2xl font-semibold mb-4 text-center text-gray-800">
          Lista de Usuarios
        </h1>

        <!-- Tabla de usuarios -->
        <div class="ag-theme-quartz" style="height: 350px; width: 100%">
          <AgGridVue
            class="ag-theme-quartz"
            :columnDefs="colDefs"
            :rowData="users"
            rowSelection="single"
            :defaultColDef="defaultColDef"
            style="width: 103%; height: 100%"
            :localeText="localeText"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onUnmounted, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";
import { AgGridVue } from "ag-grid-vue3";
import { localeText } from "@/Helpers/AgGridLocaleText.ts";

const users = ref();

// Definición de columnas para la tabla
const colDefs = ref([
  {
    field: "name",
    headerName: "Nombre de Usuario",
    minWidth: 200,
  },
  {
    field: "email",
    headerName: "Correo Electrónico",
    minWidth: 250,
  },
  {
    field: "created_at",
    headerName: "Fecha de Registro",
    minWidth: 200,
    valueFormatter: (params) => new Date(params.value).toLocaleString(),
  },
  {
    headerName: "Opciones",
    minWidth: 200,
    cellRenderer: (params) => {
      const container = document.createElement("div");
      container.classList.add("d-flex", "gap-2");

      // Botón para editar al usuario
      const editButton = document.createElement("button");
      editButton.innerHTML = '<i class="fa-regular fa-pen-to-square"></i>';
      editButton.classList.add("btn", "btn-sm", "btn-warning");
      editButton.setAttribute("title", "Editar Usuario");
      editButton.onclick = () => editUser(params.data);
      container.appendChild(editButton);

      // Botón para eliminar al usuario
      const deleteButton = document.createElement("button");
      deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
      deleteButton.classList.add("btn", "btn-sm", "btn-danger");
      deleteButton.setAttribute("title", "Eliminar Usuario");
      deleteButton.onclick = () => deleteUser(params.data);
      container.appendChild(deleteButton);

      return container;
    },
  },
]);

// Configuración por defecto de las columnas
const defaultColDef = {
  filter: true,
  sortable: true,
  resizable: true,
};

const getUsers = async () => {
  await axios.get(route("users.getUsers"), {}).then((res) => {
    users.value = res.data;
    console.log("Usuarios: ", users.value);
  });
};

// Función para redirigir al formulario de edición de usuarios
const editUser = (user) => {
  router.get(route("users.edit", user.id));
};

// Función para eliminar al usuario
const deleteUser = (user) => {
  if (confirm(`¿Estás seguro de eliminar a ${user.name}?`)) {
    router.delete(route("users.destroy", user.id), {
      onSuccess: () => {
        // Eliminar el usuario del arreglo local
        const index = users.value.findIndex((u) => u.id === user.id);
        if (index !== -1) {
          users.value.splice(index, 1); // Eliminar del arreglo reactivo
          alert(`Usuario ${user.name} eliminado con éxito.`);
        }
      },
    });
  }
};

onMounted(() => {
  getUsers();
});
</script>
