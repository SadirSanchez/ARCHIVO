<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';

const isSidebarOpen = ref(false);
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

// Controlador para el submenú de "Usuarios"
const isUsuariosOpen = ref(false); // Variable para abrir/cerrar el submenú

// Obtenemos los datos del usuario desde la página (usando Inertia)
const { props } = usePage();
const user = props.auth.user; // Aquí está el usuario autenticado
</script>

<template>
  <div class="flex h-screen bg-gray-100 font-poppins">
    <!-- Menú lateral -->
    <div 
      :class="{'w-40': isSidebarOpen, 'w-16': !isSidebarOpen}" 
      class="bg-white text-blue-600 transition-all duration-300 shadow-md border-r border-gray-300 flex flex-col h-full">
      
      <!-- Botón de alternar menú -->
      <button 
        @click="toggleSidebar" 
        class="px-4 py-3 hover:bg-gray-100 focus:outline-none transition-all flex items-center justify-center transform hover:scale-105">
        <svg v-if="isSidebarOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-auto text-blue-600 transition-all hover:text-blue-800">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-auto text-blue-600 transition-all hover:text-blue-800">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Opciones del menú -->
      <div v-if="isSidebarOpen" class="mt-6 flex-grow">
        <ul class="space-y-4 px-4 flex flex-col justify-center items-start">
          <li>
            <NavLink 
              :href="route('documents.index')" 
              :active="route().current('documents.index')" 
              class="menu-item clean-link">
              Documentos
            </NavLink>
          </li>
          <li class="relative">
            <!-- Opción de Usuarios con acción para desplegar el submenú -->
            <a 
              href="#" 
              @click.prevent="isUsuariosOpen = !isUsuariosOpen" 
              class="menu-item clean-link flex items-center justify-between w-full">
              <span>Usuarios</span>
              <!-- Icono de flecha -->
              <svg v-if="isUsuariosOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-blue-600">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </a>
            <!-- Submenú desplegable -->
            <ul 
              v-if="isUsuariosOpen" 
              class="mt-2 pl-6 bg-gray-100 border border-gray-300 rounded-lg shadow-md">
              <li>
                <a 
                  href="#" 
                  class="menu-item clean-link block py-2 px-4 text-sm hover:bg-gray-200 rounded-lg">
                  Ver Usuarios
                </a>
              </li>
              <li>
                <a 
                  href="#" 
                  class="menu-item clean-link block py-2 px-4 text-sm hover:bg-gray-200 rounded-lg">
                  Registrar
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a 
             :href="route('documents.index')" 
              :active="route().current('documents.index')"  
              class="menu-item clean-link">
              Alertas
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Área principal -->
    <div class="flex-1 flex flex-col">
      <!-- Menú superior -->
      <div class="bg-white text-blue-600 px-3 py-1.5 shadow-md flex justify-between items-center border-b border-gray-300">
        <!-- Enlace a Inicio -->
        <NavLink 
          :href="route('dashboard')" 
          :active="route().current('dashboard')" 
          class="header-item clean-link">
          <div class="relative flex items-center">
            <!-- Icono GIF delante de 'Inicio' -->
            <img src="/assets/images/gif/folder.gif" alt="Icono GIF" class="absolute w-8 h-8 opacity-80 left-0 z-10" />
            
            <span class="menu-item clean-link ml-10">Inicio</span> <!-- Desplazamos el texto para que no se superponga con el icono -->
          </div>
        </NavLink>
        
        <!-- Dropdown con el correo electrónico -->
        <Dropdown>
          <template #trigger>
            <!-- Mostrar el correo del usuario autenticado -->
            <button class="menu-item header-item clean-link">
              {{ user.name }} <!-- Cambié el correo por el nombre -->
            </button>
          </template>
          <template #content>
            <DropdownLink :href="route('profile.edit')" class="menu-item dropdown-item">
              Profile
            </DropdownLink>
            <DropdownLink :href="route('logout')" method="post" as="button" class="menu-item dropdown-item">
              Log Out
            </DropdownLink>
          </template>
        </Dropdown>
      </div>

      <!-- Contenido principal -->
      <main class="p-6 bg-gray-100 flex-grow">
        <slot />
      </main>
    </div>
  </div>
</template>

<style scoped>
/* Mantengo tus estilos con los ajustes para el submenú */
.menu-item {
  display: flex;
  align-items: center;
  padding: 8px 16px;
  font-size: 1rem;
  font-weight: 500;
  color: #4f9ef1; /* Azul */
  text-decoration: none;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.menu-item:hover {
  background-color: #e8f1ff;
  color: #2b6cb0; /* Azul oscuro */
  transform: scale(1.05);
}

.relative ul {
  position: absolute;
  left: 0;
  width: 90%; /* Ajusta el ancho del submenú */
  z-index: 20;
}

.clean-link {
  background: none;
  border: none;
  box-shadow: none;
  outline: none;
}

.bg-gray-100 {
  background-color: #f7fafc; /* Fondo gris claro */
}

.text-blue-600 {
  color: #4f9ef1; /* Azul */
}

ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.relative img {
  position: absolute;
  width: 32px; /* Ajusta el tamaño del GIF */
}
</style>
