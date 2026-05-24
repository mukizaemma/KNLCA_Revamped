<template>
    <div class="sidebar">
        <div class="logo">
            <img src="@/assets/logo.png" alt="logo" />
        </div>
        <div class="links">
            <router-link to="/dashboard/overview">
                <svg viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M960 282c529.355 0 960 430.758 960 960 0 77.139-8.922 153.148-26.541 225.882l-10.504 43.144h-560.188c-27.106 74.88-79.85 140.838-155.52 181.045-47.887 25.185-101.647 38.625-155.633 38.625-123.445 0-236.047-67.651-293.76-176.64-5.873-11.18-11.859-25.75-17.845-43.03H37.045l-10.504-43.144C8.922 1395.148 0 1319.14 0 1242c0-529.242 430.645-960 960-960Zm168.17 1229.026c47.66-49.355 61.214-125.139 27.331-189.064-42.24-79.51-403.765-413.59-403.765-413.59s73.638 486.776 115.765 566.287c7.341 13.892 16.941 25.525 27.219 36.367h-.904c2.033 2.146 4.518 3.614 6.551 5.534 4.63 4.405 9.374 8.47 14.344 12.198 3.727 2.823 7.68 5.308 11.52 7.68 5.195 3.162 10.39 6.098 15.924 8.81 4.292 1.92 8.584 3.726 13.101 5.42 5.422 1.92 10.956 3.727 16.716 5.083a159.91 159.91 0 0 0 14.23 3.049c5.76.904 11.407 1.468 17.167 1.694 2.824.113 5.535.79 8.245.79 1.92 0 3.84-.677 5.76-.677 8.245-.226 16.377-1.355 24.508-2.936 3.727-.791 7.567-1.13 11.294-2.146 11.746-3.163 23.266-7.229 34.335-13.214h.338v-.113c15.7-8.245 28.687-19.2 40.32-31.172Zm361.524-625.807 112.715-112.715-119.717-119.831-112.828 112.715 119.83 119.83Zm-614.4-254.457h169.412V471.29H875.294v159.473ZM430.306 885.22l119.83-119.83-112.715-112.716-119.83 119.83L430.306 885.22Z" fill-rule="evenodd"></path> </g></svg>
                Dashboard
            </router-link>
            <div class="dropdown" v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                <div class="dropdown-wrapper"  @click="toggleDropdown('users')">
                    <div class="dropdown-name">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect width="24" height="24" fill="white"></rect> <path fill-rule="evenodd" clip-rule="evenodd" d="M5 9.5C5 7.01472 7.01472 5 9.5 5C11.9853 5 14 7.01472 14 9.5C14 11.9853 11.9853 14 9.5 14C7.01472 14 5 11.9853 5 9.5Z" fill="#000000"></path> <path d="M14.3675 12.0632C14.322 12.1494 14.3413 12.2569 14.4196 12.3149C15.0012 12.7454 15.7209 13 16.5 13C18.433 13 20 11.433 20 9.5C20 7.567 18.433 6 16.5 6C15.7209 6 15.0012 6.2546 14.4196 6.68513C14.3413 6.74313 14.322 6.85058 14.3675 6.93679C14.7714 7.70219 15 8.5744 15 9.5C15 10.4256 14.7714 11.2978 14.3675 12.0632Z" fill="#000000"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M4.64115 15.6993C5.87351 15.1644 7.49045 15 9.49995 15C11.5112 15 13.1293 15.1647 14.3621 15.7008C15.705 16.2847 16.5212 17.2793 16.949 18.6836C17.1495 19.3418 16.6551 20 15.9738 20H3.02801C2.34589 20 1.85045 19.3408 2.05157 18.6814C2.47994 17.2769 3.29738 16.2826 4.64115 15.6993Z" fill="#000000"></path> <path d="M14.8185 14.0364C14.4045 14.0621 14.3802 14.6183 14.7606 14.7837V14.7837C15.803 15.237 16.5879 15.9043 17.1508 16.756C17.6127 17.4549 18.33 18 19.1677 18H20.9483C21.6555 18 22.1715 17.2973 21.9227 16.6108C21.9084 16.5713 21.8935 16.5321 21.8781 16.4932C21.5357 15.6286 20.9488 14.9921 20.0798 14.5864C19.2639 14.2055 18.2425 14.0483 17.0392 14.0008L17.0194 14H16.9997C16.2909 14 15.5506 13.9909 14.8185 14.0364Z" fill="#000000"></path> </g></svg>
                        Users & Our team
                    </div>
                    <div class="drop-icon">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000" d="M13.098 8H6.902c-.751 0-1.172.754-.708 1.268L9.292 12.7c.36.399 1.055.399 1.416 0l3.098-3.433C14.27 8.754 13.849 8 13.098 8Z"></path></g></svg>
                    </div>
                </div>
                <div class="drop-links" :class="{ active: dropdown == 'users' }">
                    <router-link to="/admin/admins" v-if="$loggedUser().role.role == 'superadmin'">
                        <svg class="fill" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="0" fill="none" width="20" height="20"></rect> <g> <path d="M16.95 2.58c1.96 1.95 1.96 5.12 0 7.07-1.51 1.51-3.75 1.84-5.59 1.01l-1.87 3.31-2.99.31L5 18H2l-1-2 7.95-7.69c-.92-1.87-.62-4.18.93-5.73 1.95-1.96 5.12-1.96 7.07 0zm-2.51 3.79c.74 0 1.33-.6 1.33-1.34 0-.73-.59-1.33-1.33-1.33-.73 0-1.33.6-1.33 1.33 0 .74.6 1.34 1.33 1.34z"></path> </g> </g></svg>
                        Admins & Customer care
                    </router-link>
                    <router-link to="/dashboard/doctors" v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><g> <path class="st0" d="M435.95,287.525c32.51,0,58.87-26.343,58.87-58.853c0-32.51-26.361-58.871-58.87-58.871 c-32.502,0-58.863,26.361-58.863,58.871C377.088,261.182,403.448,287.525,435.95,287.525z"></path> <path class="st0" d="M511.327,344.251c-2.623-15.762-15.652-37.822-25.514-47.677c-1.299-1.306-7.105-1.608-8.673-0.636 c-11.99,7.374-26.074,11.714-41.19,11.714c-15.099,0-29.184-4.34-41.175-11.714c-1.575-0.972-7.373-0.67-8.672,0.636 c-2.757,2.757-5.765,6.427-8.698,10.683c7.935,14.94,14.228,30.81,16.499,44.476c2.27,13.7,1.533,26.67-2.138,38.494 c13.038,4.717,28.673,6.787,44.183,6.787C476.404,397.014,517.804,382.987,511.327,344.251z"></path> <path class="st0" d="M254.487,262.691c52.687,0,95.403-42.716,95.403-95.402c0-52.67-42.716-95.386-95.403-95.386 c-52.678,0-95.378,42.716-95.378,95.386C159.109,219.975,201.808,262.691,254.487,262.691z"></path> <path class="st0" d="M335.269,277.303c-2.07-2.061-11.471-2.588-14.027-1.006c-19.448,11.966-42.271,18.971-66.755,18.971 c-24.466,0-47.3-7.005-66.738-18.971c-2.555-1.583-11.956-1.055-14.026,1.006c-16.021,16.004-37.136,51.782-41.384,77.288 c-10.474,62.826,56.634,85.508,122.148,85.508c65.532,0,132.639-22.682,122.165-85.508 C372.404,329.085,351.289,293.307,335.269,277.303z"></path> <path class="st0" d="M76.049,287.525c32.502,0,58.862-26.343,58.862-58.853c0-32.51-26.36-58.871-58.862-58.871 c-32.511,0-58.871,26.361-58.871,58.871C17.178,261.182,43.538,287.525,76.049,287.525z"></path> <path class="st0" d="M115.094,351.733c2.414-14.353,9.225-31.253,17.764-46.88c-2.38-3.251-4.759-6.083-6.955-8.279 c-1.299-1.306-7.097-1.608-8.672-0.636c-11.991,7.374-26.076,11.714-41.182,11.714c-15.108,0-29.202-4.34-41.183-11.714 c-1.568-0.972-7.382-0.67-8.681,0.636c-9.887,9.854-22.882,31.915-25.514,47.677c-6.468,38.736,34.924,52.762,75.378,52.762 c14.437,0,29.016-1.777,41.459-5.84C113.587,379.108,112.757,365.835,115.094,351.733z"></path> </g> </g></svg>
                        Doctors
                    </router-link>
                    <router-link to="/dashboard/staff" v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg fill="#000000" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 218.582 218.582" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M160.798,64.543c-1.211-1.869-2.679-3.143-4.046-4.005c-0.007-2.32-0.16-5.601-0.712-9.385 c0.373-4.515,1.676-29.376-13.535-40.585C133.123,3.654,122.676,0,112.294,0c-8.438,0-16.474,2.398-22.629,6.752 c-5.543,3.922-8.596,8.188-10.212,11.191c-4.78,0.169-14.683,2.118-19.063,14.745c-4.144,11.944-0.798,19.323,1.663,22.743 c-0.161,1.978-0.219,3.717-0.223,5.106c-1.367,0.862-2.835,2.136-4.046,4.005c-2.74,4.229-3.206,9.9-1.386,16.859 c3.403,13.012,11.344,15.876,15.581,16.451c2.61,5.218,8.346,15.882,14.086,21.24c2.293,2.14,5.274,3.946,8.86,5.37 c4.577,1.816,9.411,2.737,14.366,2.737s9.789-0.921,14.366-2.737c3.586-1.424,6.567-3.23,8.86-5.37 c5.74-5.358,11.476-16.022,14.086-21.24c4.236-0.575,12.177-3.44,15.581-16.452C164.004,74.443,163.538,68.771,160.798,64.543z M152.509,78.871c-2.074,7.932-5.781,9.116-7.807,9.116c-0.144,0-0.252-0.008-0.316-0.013c-2.314-0.585-4.454,0.631-5.466,2.808 c-1.98,4.256-8.218,16.326-13.226,21.001c-1.377,1.285-3.304,2.425-5.726,3.386c-6.796,2.697-14.559,2.697-21.354,0 c-2.422-0.961-4.349-2.101-5.726-3.386c-5.008-4.675-11.246-16.745-13.226-21.001c-0.842-1.81-2.461-2.953-4.314-2.953 c-0.376,0-0.762,0.047-1.153,0.146c-0.064,0.006-0.172,0.013-0.315,0.013c-2.025,0-5.732-1.185-7.807-9.115 c-1.021-3.903-1.012-7.016,0.024-8.764c0.603-1.016,1.459-1.358,1.739-1.446c2.683-0.291,4.299-2.64,4.075-5.347 c-0.005-0.066-0.18-2.39,0.042-5.927c3.441-1.479,8.939-4.396,13.574-9.402c2.359-2.549,4.085-5.672,5.314-8.537 c3.351,2.736,8.095,5.951,14.372,8.729c10.751,4.758,32.237,7.021,41.307,7.794c0.375,4.317,0.156,7.263,0.15,7.333 c-0.236,2.715,1.383,5.066,4.075,5.357c0.28,0.088,1.136,0.431,1.739,1.446C153.521,71.856,153.53,74.969,152.509,78.871z M184.573,145.65l-43.715-17.485c-1.258-0.502-2.665-0.473-3.903,0.08c-1.236,0.555-2.195,1.588-2.655,2.862l-10.989,30.382 l-2.176-6.256l3.462-8.463c0.63-1.542,0.452-3.297-0.477-4.681c-0.929-1.383-2.485-2.213-4.151-2.213H98.614 c-1.666,0-3.223,0.83-4.151,2.213c-0.929,1.384-1.107,3.139-0.477,4.681l3.462,8.463l-2.176,6.256l-10.989-30.382 c-0.46-1.274-1.419-2.308-2.655-2.862c-1.238-0.554-2.646-0.583-3.903-0.08L34.009,145.65 c-13.424,5.369-22.098,18.182-22.098,32.641v35.291c0,2.762,2.239,5,5,5h184.76c2.761,0,5-2.238,5-5v-35.291 C206.671,163.832,197.997,151.02,184.573,145.65z M183.054,192.718c0,2.762-2.239,5-5,5h-33.57c-2.761,0-5-2.238-5-5v-15.59 c0-2.762,2.239-5,5-5h33.57c2.761,0,5,2.238,5,5V192.718z"></path> </g></svg>
                        Staff
                    </router-link>
                </div>
            </div>
            <div class="dropdown" v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                <div class="dropdown-wrapper" @click="toggleDropdown('clinical')">
                    <div class="dropdown-name">
                        <svg viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M55.78 36.45l-18.82 2.8l-20.35-10.74S14.86 39.04 26.87 43.1c10.81 3.65 24.45 3.39 38.4 3.61c14.41.22 23.31-.32 26.49 2.33c1.8 1.5.67 4.46.67 4.46s7.06-1.01 7.06-1.37s-.09-8.75-.8-9.02c-.71-.27-23.57-6.52-23.57-6.52l-9.21-.06c-4.91-.04-9.94-.07-10.13-.08z" fill="#000000"></path><path d="M25.7 32.19l-2.32-6.61l5-2.32l9.92 3.66l7.24.63s-.09 2.51-7.41 2.16c-8.03-.39-9.03-1.82-10.06-.96c-.99.82-.6 2.49.38 3.41c2.01 1.88 6.53 2.95 6.53 2.95l-9.28-2.92z" fill="#000000"></path><path d="M27.76 61.85s-1.61 2.77-1.16 6.7c.45 3.93 3.39 8.22 10.09 10.27s18.85 3.75 28.68 4.73s18.4 2.14 20.37 3.13c1.97.98 1.34 3.13 1.61 3.39c.27.27 3.57 1.34 4.38.89c.8-.45.63-8.4.63-8.4l-16.62-8.31s-3.77-.49-10.14-1.13c-5.66-.58-9.19-1.17-9.19-1.17s-14.79.52-15.51-.2c-.72-.7-13.14-9.9-13.14-9.9z" fill="#000000"></path><path d="M55.56 105.76l19.27 2.63l4.82 4.38l8.4 4.91l3.39 4.02s-.34 2.19-2.41 1.34c-1.97-.8-2.23-3.66-7.95-5.99s-10.45-2.32-15.99-2.68s-16.79-1.7-21.89-3.57c-4.17-1.54-7.68-4.46-7.86-9.02c-.22-5.45 4.71-7.5 4.71-7.5l4.04 10.63l11.47.85z" fill="#000000"></path><path d="M61.21 24.67v95.41c0 2.33.78 4.36 4.19 4.34c3.98-.02 4.28-2.16 4.26-3.87c-.02-1.97-.08-96.03-.08-96.03l-8.37.15z" fill="#000000"></path><path d="M34.9 34.88c-7.85-1.59-10.67-5.35-9.54-8.08c.94-2.27 4.03-1.95 5.43-1.32c.97.43 4.04 2.51 8.15 2.79s6.59-.72 6.59-.72s.3-.76-1.09-.88c-2.07-.18-3.56-.07-3.48-1.18c.07-.95 1.98-1.11 3.85-1.32c2.49-.28 4.11-.65 4.22-1.33c.08-.48-3.08-8.38-14.24-7.95c-10.93.42-18.42 6.77-18.28 15.05c.11 6.41 8.37 9.94 16.94 11.39c8.6 1.46 22.34 1.44 22.34 1.44v-6.33c.01-.01-12.32.19-20.89-1.56zm.18-13.44c.03-1.26.58-2.57 2.25-2.5c1.45.06 1.93 1.51 1.9 2.64c-.03 1.13-.8 2.29-2.09 2.19c-1.29-.09-2.1-1.14-2.06-2.33z" fill="#000000"></path><path d="M61.21 24.67v4.1s1.29 1.49 4.27 1.42s4.12-1.15 4.12-1.15l.03-4.16s4.26-.87 6.1-5.1c1.69-3.89 1.06-7.86 1.06-7.86L55 11.81s-.94 4.5.81 8.21c1.87 3.97 5.4 4.65 5.4 4.65z" fill="#000000"></path><path d="M65.69 20.17c9.17.24 11.15-7.72 11.15-7.72s-.68-8.93-11.04-9.12c-9-.17-10.68 7.9-10.81 8.48s2.09 8.14 10.7 8.36z" fill="#000000"></path><path d="M104.93 47.44s.74 2.08-.25 7.17c-.32 1.62-2.55 7.18-12.76 8.77c-9.69 1.51-22.35 1.65-22.35 1.65v3.91s-2.35.35-4.44.35s-3.89-.48-3.89-.48v-3.78s-14.13.13-16.55.13c-1.3 0-4.36.33-4.36 2.5c0 2.79 4.72 4.24 4.72 4.24s-9.48.78-9.57.09c-.09-.7.96-12.18.96-12.18l30.35-2.35s26.09-.26 27.31-.7c1.22-.43 10.83-9.32 10.83-9.32z" fill="#000000"></path><path d="M46.96 103.21s-.73-2.65 2.87-2.69c2.5-.02 11.37.15 11.37.15v5.3l8.45.02l-.01-5.16s17.31.51 22.76-2.27c7.17-3.65 7.48-7.9 7.4-11.6c-.09-3.7-7.68 1.37-7.68 1.37l-8 6.17l-27.78.45l-13.6 2.75l-.26 6.8l4.48-1.29z" fill="#000000"></path><path d="M74.75 112.81l.08-4.42s6.37 1.03 10.05 3.82c5.93 4.52 6.44 8.36 6.57 9.49c.13 1.13-3.58-3.02-5.1-4.21c-5.79-4.51-11.6-4.68-11.6-4.68z" fill="#000000"></path><path d="M55.68 110.46l-.08-4.71s-9.84-1.18-9.87-4.33c-.02-2.59 1.93-3.47 8.75-3.2c6.69.26 30.89 1.39 39.22-3.19c3.68-2.02 6.05-4.6 6.1-7.93c.04-2.74-1.19-5.24-4.39-7.45c-6.13-4.23-19.68-5.37-19.68-5.37l-.16 6.52s12.63 1.4 12.99 6.46c.31 4.28-18.35 4.78-23.58 4.75c-8.47-.05-28.41-1.86-28.26 7.4c.12 6.9 8.15 9.36 13.72 10.23c2.98.44 5.24.82 5.24.82z" fill="#000000"></path><path d="M55.55 79.16l.85-7.21s-3.07-.39-6.29-.79c-5.04-.63-11.68-2.12-11.58-5.01c.19-5.52 9.96-4.73 20.31-4.59c17.51.23 32.28-.87 37.43-2.1c7.78-1.87 9.11-6.7 8.87-10.82c-.2-3.55-1.68-5.82-4.45-7.83c-2.39-1.73-5.79-2.7-9.38-3.21c-5.61-.8-16.21-1.03-16.21-1.03l.08 6.63s13.04.26 16.03 1.4c4.9 1.87 3.66 8.09-1.63 9.1s-14.67 1.24-24.74 1.48c-6.35.15-26.62-1.94-34.36 3.77c-1.83 1.35-3.3 3.14-3.39 5.5c-.36 9.28 12.89 11.8 21.36 13.5c4.06.82 7.1 1.21 7.1 1.21z" fill="#000000"></path></g></svg>
                        Clinical
                    </div>
                    <div class="drop-icon">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000" d="M13.098 8H6.902c-.751 0-1.172.754-.708 1.268L9.292 12.7c.36.399 1.055.399 1.416 0l3.098-3.433C14.27 8.754 13.849 8 13.098 8Z"></path></g></svg>
                    </div>
                </div>
                <div class="drop-links" :class="{ active: dropdown == 'clinical' }">
                    <router-link to="/admin/departments"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M2 7C2 5.11438 2 4.17157 2.58579 3.58579C3.17157 3 4.11438 3 6 3H18C19.8856 3 20.8284 3 21.4142 3.58579C22 4.17157 22 5.11438 22 7C22 8.88562 22 9.82843 21.4142 10.4142C20.8284 11 19.8856 11 18 11H6C4.11438 11 3.17157 11 2.58579 10.4142C2 9.82843 2 8.88562 2 7ZM6 6.25C5.58579 6.25 5.25 6.58579 5.25 7C5.25 7.41421 5.58579 7.75 6 7.75H8C8.41421 7.75 8.75 7.41421 8.75 7C8.75 6.58579 8.41421 6.25 8 6.25H6ZM10.25 7C10.25 6.58579 10.5858 6.25 11 6.25H18C18.4142 6.25 18.75 6.58579 18.75 7C18.75 7.41421 18.4142 7.75 18 7.75H11C10.5858 7.75 10.25 7.41421 10.25 7Z"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M2 17C2 15.1144 2 14.1716 2.58579 13.5858C3.17157 13 4.11438 13 6 13H18C19.8856 13 20.8284 13 21.4142 13.5858C22 14.1716 22 15.1144 22 17C22 18.8856 22 19.8284 21.4142 20.4142C20.8284 21 19.8856 21 18 21H6C4.11438 21 3.17157 21 2.58579 20.4142C2 19.8284 2 18.8856 2 17ZM6 16.25C5.58579 16.25 5.25 16.5858 5.25 17C5.25 17.4142 5.58579 17.75 6 17.75H8C8.41421 17.75 8.75 17.4142 8.75 17C8.75 16.5858 8.41421 16.25 8 16.25H6ZM10.25 17C10.25 16.5858 10.5858 16.25 11 16.25H18C18.4142 16.25 18.75 16.5858 18.75 17C18.75 17.4142 18.4142 17.75 18 17.75H11C10.5858 17.75 10.25 17.4142 10.25 17Z"></path> </g></svg>
                        Departments
                    </router-link>
                    <router-link to="/admin/services"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.66749 3.15144C5.88138 3.9264 5.57692 5.0991 4.96802 7.44451L4.88378 7.76897C4.05598 10.9576 3.64207 12.5519 4.39389 13.6719C4.46887 13.7837 4.55129 13.8902 4.64058 13.9909C5.5358 15 7.18295 15 10.4772 15H11.2559V21.25H9.00586C8.59165 21.25 8.25586 21.5858 8.25586 22C8.25586 22.4142 8.59165 22.75 9.00586 22.75H15.0059C15.4201 22.75 15.7559 22.4142 15.7559 22C15.7559 21.5858 15.4201 21.25 15.0059 21.25H12.7559V15H13.5358C14.8551 15 15.9102 15 16.7586 14.9352C16.7568 14.9565 16.7559 14.9782 16.7559 15V17C16.7559 17.4142 17.0916 17.75 17.5059 17.75C17.9201 17.75 18.2559 17.4142 18.2559 17V15V14.6817C18.7241 14.5324 19.0866 14.3131 19.3724 13.9909C19.4617 13.8902 19.5441 13.7837 19.6191 13.6719C20.3709 12.5519 19.957 10.9576 19.1292 7.76898L19.045 7.44451C18.4361 5.0991 18.1316 3.9264 17.3455 3.15144C17.1176 2.92678 16.8636 2.73028 16.5889 2.56616C15.6412 2 14.4297 2 12.0065 2C9.58334 2 8.37176 2 7.42412 2.56616C7.14941 2.73028 6.89538 2.92678 6.66749 3.15144Z"></path> </g></svg>
                        Services
                    </router-link>
                </div>
            </div>
            <div class="dropdown" v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                <div class="dropdown-wrapper" @click="toggleDropdown('media')">
                    <div class="dropdown-name">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7.50632 3.14928C6.1753 2.29363 4.4248 3.24931 4.4248 4.83164V19.1683C4.4248 20.7506 6.1753 21.7063 7.50632 20.8507L18.6571 13.6823C19.8817 12.8951 19.8817 11.1049 18.6571 10.3176L7.50632 3.14928Z" fill="#000000"></path> </g></svg>
                        Media
                    </div>
                    <div class="drop-icon">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000" d="M13.098 8H6.902c-.751 0-1.172.754-.708 1.268L9.292 12.7c.36.399 1.055.399 1.416 0l3.098-3.433C14.27 8.754 13.849 8 13.098 8Z"></path></g></svg>
                    </div>
                </div>
                <div class="drop-links" :class="{ active: dropdown == 'media' }">
                    <router-link to="/admin/slides"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path fill="none" d="M0 0h24v24H0z"></path> <path d="M13 18v2h4v2H7v-2h4v-2H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-8zM10 7.5v6l5-3-5-3z"></path> </g> </g></svg>
                        Slides
                    </router-link>
                    <router-link to="/admin/updates"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" d="M2 6a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V6zm5 1a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H7zm1 4V9h2v2H8zm7-4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2zm0 4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2zm-8 4a1 1 0 1 0 0 2h10a1 1 0 1 0 0-2H7z" clip-rule="evenodd"></path></g></svg>
                        Updates
                    </router-link>
                    <router-link to="/admin/gallery"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.58078 19.0112L2.56078 19.0312C2.29078 18.4413 2.12078 17.7713 2.05078 17.0312C2.12078 17.7613 2.31078 18.4212 2.58078 19.0112Z"></path> <path d="M9.00109 10.3811C10.3155 10.3811 11.3811 9.31553 11.3811 8.00109C11.3811 6.68666 10.3155 5.62109 9.00109 5.62109C7.68666 5.62109 6.62109 6.68666 6.62109 8.00109C6.62109 9.31553 7.68666 10.3811 9.00109 10.3811Z"></path> <path d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.19C2 17.28 2.19 18.23 2.56 19.03C3.42 20.93 5.26 22 7.81 22H16.19C19.83 22 22 19.83 22 16.19V13.9V7.81C22 4.17 19.83 2 16.19 2ZM20.37 12.5C19.59 11.83 18.33 11.83 17.55 12.5L13.39 16.07C12.61 16.74 11.35 16.74 10.57 16.07L10.23 15.79C9.52 15.17 8.39 15.11 7.59 15.65L3.85 18.16C3.63 17.6 3.5 16.95 3.5 16.19V7.81C3.5 4.99 4.99 3.5 7.81 3.5H16.19C19.01 3.5 20.5 4.99 20.5 7.81V12.61L20.37 12.5Z"></path> </g></svg>
                        Gallery
                    </router-link>
                </div>
            </div>
            <div class="dropdown" v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                <div class="dropdown-wrapper" @click="toggleDropdown('website')">
                    <div class="dropdown-name">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16.5744 19.1999L12.6361 15.2616L11.4334 16.4643C10.2022 17.6955 9.58656 18.3111 8.92489 18.1658C8.26322 18.0204 7.96225 17.2035 7.3603 15.5696L5.3527 10.1205C4.15187 6.86106 3.55146 5.23136 4.39141 4.39141C5.23136 3.55146 6.86106 4.15187 10.1205 5.35271L15.5696 7.3603C17.2035 7.96225 18.0204 8.26322 18.1658 8.92489C18.3111 9.58656 17.6955 10.2022 16.4643 11.4334L15.2616 12.6361L19.1999 16.5744C19.6077 16.9821 19.8116 17.186 19.9058 17.4135C20.0314 17.7168 20.0314 18.0575 19.9058 18.3608C19.8116 18.5882 19.6077 18.7921 19.1999 19.1999C18.7921 19.6077 18.5882 19.8116 18.3608 19.9058C18.0575 20.0314 17.7168 20.0314 17.4135 19.9058C17.186 19.8116 16.9821 19.6077 16.5744 19.1999Z" fill="#000"></path> </g></svg>
                        Website users
                    </div>
                    <div class="drop-icon">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#000" d="M13.098 8H6.902c-.751 0-1.172.754-.708 1.268L9.292 12.7c.36.399 1.055.399 1.416 0l3.098-3.433C14.27 8.754 13.849 8 13.098 8Z"></path></g></svg>
                    </div>
                </div>
                <div class="drop-links" :class="{ active: dropdown == 'website' }">
                    <router-link to="/admin/contacts"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path fill="none" d="M0 0h24v24H0z"></path> <path d="M2 22a8 8 0 1 1 16 0H2zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm10 4h4v2h-4v-2zm-3-5h7v2h-7v-2zm2-5h5v2h-5V7z"></path> </g> </g></svg>
                        Contacts
                    </router-link>
                    <router-link to="/admin/suggestions"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg fill="#000000" viewBox="-1 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 9.583A7.917 7.917 0 1 1 8.5 1.666a7.917 7.917 0 0 1 7.917 7.917zm-4.231-1.918a3.692 3.692 0 1 0-7.384 0 3.748 3.748 0 0 0 .389 1.665 7.163 7.163 0 0 0 .723 1.137 2.128 2.128 0 0 1 .483.857v.817a.633.633 0 0 0 .634.633h2.926a.633.633 0 0 0 .633-.633v-.817a2.125 2.125 0 0 1 .483-.857 7.142 7.142 0 0 0 .724-1.137 3.748 3.748 0 0 0 .389-1.665zm-1.913 5.942a.317.317 0 0 0-.316-.316H7.03a.317.317 0 1 0 0 .633h2.926a.317.317 0 0 0 .316-.317zm-.473.933a.158.158 0 0 0-.15-.107H7.298a.158.158 0 0 0-.098.283 2.075 2.075 0 0 0 2.547 0 .158.158 0 0 0 .053-.176z"></path></g></svg>
                        Suggestion box
                    </router-link>
                    <router-link to="/admin/subscribers"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 0a2 2 0 0 0-1.81 1.15L7.556 6.758 1.7 7.642a2 2 0 0 0-1.13 3.374l4.3 4.408-1.02 6.235a2 2 0 0 0 2.94 2.073L12 20.86l5.216 2.89a2 2 0 0 0 2.942-2.073l-1.02-6.237 4.293-4.39a2 2 0 0 0-1.124-3.376l-5.857-.9-2.64-5.624A2 2 0 0 0 12 0z"></path> </g></svg>
                        Subscribers
                    </router-link>
                </div>
            </div>
            <router-link to="/dashboard/appointments" v-if="$loggedUser().role.role == 'doctor' || $loggedUser().role.role == 'customer-care' || $loggedUser().role.role == 'admin'">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" d="M2 6a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V6zm5 1a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H7zm1 4V9h2v2H8zm7-4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2zm0 4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2zm-8 4a1 1 0 1 0 0 2h10a1 1 0 1 0 0-2H7z" clip-rule="evenodd"></path></g></svg>
                Appointments
            </router-link>
            <router-link to="/admin/partners"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">
                <svg viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="m 1.4358383,12.895149 c -0.38924,-0.1993 -0.43281,-0.3751 -0.41279,-1.665 0.0158,-1.0195 0.0314,-1.1697 0.14735,-1.4205004 0.26312,-0.5694 0.88589,-1.0631 1.46037,-1.1579 l 0.21,-0.035 0.62728,1.0597 c 0.345,0.5829004 0.63415,1.0358004 0.64256,1.0065004 0.008,-0.029 0.0415,-0.3472 0.0736,-0.7065004 0.0525,-0.5882 0.0468,-0.6826 -0.0575,-0.9472 -0.0637,-0.1617 -0.11586,-0.32 -0.11586,-0.3517 0,-0.033 0.26499,-0.058 0.62678,-0.058 l 0.62678,0 -0.12063,0.345 c -0.10456,0.2991 -0.11523,0.4309 -0.0802,0.9905 0.0222,0.3551004 0.0611,0.6584004 0.0864,0.6740004 0.0253,0.016 0.32158,-0.4318 0.65846,-0.9942004 l 0.61252,-1.0226 0.18995,0.04 c 0.58752,0.1229 1.19054,0.5979 1.42811,1.1248 0.12949,0.2872004 0.1425,0.4062004 0.1588,1.4528004 0.0156,0.9994 0.005,1.1659 -0.0896,1.35 -0.21721,0.425 -0.1746,0.4199 -3.4974,0.4199 -2.70948,0 -2.98802,-0.01 -3.17496,-0.1049 z m 2.71495,-4.9624004 c -0.76247,-0.3317 -1.3488,-1.7133 -1.07583,-2.5352 0.48535,-1.4612 2.58633,-1.4612 3.07167,0 0.27559,0.8297 -0.31945,2.2162 -1.08916,2.5378 -0.25463,0.1064 -0.65878,0.1053 -0.90668,0 z m 3.58006,-2.0213 0,-0.6365 -0.34018,-0.028 c -0.27583,-0.023 -0.36661,-0.059 -0.48,-0.1908 -0.13962,-0.1623 -0.13984,-0.1653 -0.13984,-1.9339 l 0,-1.7713 0.17539,-0.1754 0.17539,-0.1753 2.76131,0 2.7613097,0 0.16835,0.1448 0.16835,0.1448 0,1.8101 0,1.8102 -0.19595,0.175 -0.19595,0.1751 -1.7831,0 -1.7830997,0 -0.64599,0.644 -0.64599,0.644 0,-0.6366 z"></path></g></svg>
                Partners
            </router-link>
            <router-link to="/admin/settings">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2788 2.15224C13.9085 2 13.439 2 12.5 2C11.561 2 11.0915 2 10.7212 2.15224C10.2274 2.35523 9.83509 2.74458 9.63056 3.23463C9.53719 3.45834 9.50065 3.7185 9.48635 4.09799C9.46534 4.65568 9.17716 5.17189 8.69017 5.45093C8.20318 5.72996 7.60864 5.71954 7.11149 5.45876C6.77318 5.2813 6.52789 5.18262 6.28599 5.15102C5.75609 5.08178 5.22018 5.22429 4.79616 5.5472C4.47814 5.78938 4.24339 6.1929 3.7739 6.99993C3.30441 7.80697 3.06967 8.21048 3.01735 8.60491C2.94758 9.1308 3.09118 9.66266 3.41655 10.0835C3.56506 10.2756 3.77377 10.437 4.0977 10.639C4.57391 10.936 4.88032 11.4419 4.88029 12C4.88026 12.5581 4.57386 13.0639 4.0977 13.3608C3.77372 13.5629 3.56497 13.7244 3.41645 13.9165C3.09108 14.3373 2.94749 14.8691 3.01725 15.395C3.06957 15.7894 3.30432 16.193 3.7738 17C4.24329 17.807 4.47804 18.2106 4.79606 18.4527C5.22008 18.7756 5.75599 18.9181 6.28589 18.8489C6.52778 18.8173 6.77305 18.7186 7.11133 18.5412C7.60852 18.2804 8.2031 18.27 8.69012 18.549C9.17714 18.8281 9.46533 19.3443 9.48635 19.9021C9.50065 20.2815 9.53719 20.5417 9.63056 20.7654C9.83509 21.2554 10.2274 21.6448 10.7212 21.8478C11.0915 22 11.561 22 12.5 22C13.439 22 13.9085 22 14.2788 21.8478C14.7726 21.6448 15.1649 21.2554 15.3694 20.7654C15.4628 20.5417 15.4994 20.2815 15.5137 19.902C15.5347 19.3443 15.8228 18.8281 16.3098 18.549C16.7968 18.2699 17.3914 18.2804 17.8886 18.5412C18.2269 18.7186 18.4721 18.8172 18.714 18.8488C19.2439 18.9181 19.7798 18.7756 20.2038 18.4527C20.5219 18.2105 20.7566 17.807 21.2261 16.9999C21.6956 16.1929 21.9303 15.7894 21.9827 15.395C22.0524 14.8691 21.9088 14.3372 21.5835 13.9164C21.4349 13.7243 21.2262 13.5628 20.9022 13.3608C20.4261 13.0639 20.1197 12.558 20.1197 11.9999C20.1197 11.4418 20.4261 10.9361 20.9022 10.6392C21.2263 10.4371 21.435 10.2757 21.5836 10.0835C21.9089 9.66273 22.0525 9.13087 21.9828 8.60497C21.9304 8.21055 21.6957 7.80703 21.2262 7C20.7567 6.19297 20.522 5.78945 20.2039 5.54727C19.7799 5.22436 19.244 5.08185 18.7141 5.15109C18.4722 5.18269 18.2269 5.28136 17.8887 5.4588C17.3915 5.71959 16.7969 5.73002 16.3099 5.45096C15.8229 5.17191 15.5347 4.65566 15.5136 4.09794C15.4993 3.71848 15.4628 3.45833 15.3694 3.23463C15.1649 2.74458 14.7726 2.35523 14.2788 2.15224ZM12.5 15C14.1695 15 15.5228 13.6569 15.5228 12C15.5228 10.3431 14.1695 9 12.5 9C10.8305 9 9.47716 10.3431 9.47716 12C9.47716 13.6569 10.8305 15 12.5 15Z"></path> </g></svg>
                Settings
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            dropdown: ''
        }
    },
    methods: {
        toggleDropdown(dropdown){
            if(this.dropdown === dropdown){
                this.dropdown = ''
            }else{
                this.dropdown = dropdown
            }
        },
        activeDropdown(){
            if(this.$route.path.includes('admins') || this.$route.path.includes('doctors') || this.$route.path.includes('staff')){
                this.toggleDropdown('users')
            } else if(this.$route.path.includes('departments') || this.$route.path.includes('services')){
                this.toggleDropdown('clinical')
            } else if(this.$route.path.includes('slides') || this.$route.path.includes('updates') || this.$route.path.includes('gallery')){
                this.toggleDropdown('media')
            } else if(this.$route.path.includes('contacts') || this.$route.path.includes('suggestions') || this.$route.path.includes('subscribers')){
                this.toggleDropdown('website')
            }
        }
    },
    mounted(){
        this.activeDropdown()
    },
}
</script>

<style lang="scss" scoped>
@import "../scss/index.scss";
.sidebar{
    border-right: 1px solid #eee;
    width: 290px;
    height: 100%;
    padding: 20px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
    .logo{
        width: 130px;
        height: 50px;
        margin: 0 0 20px 0;
        img{
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    }
    .links{
        width: 100%;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        height: calc(100vh - 140px);
        &::-webkit-scrollbar {
            width: 5px;
        }
        &::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        &::-webkit-scrollbar-thumb {
            background: $lightred; 
            border-radius: 5px;
        }
        .dropdown{
            width: 100%;
            .dropdown-wrapper{
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 15px 30px;
                margin: 5px 0;
                border-bottom: 1px solid sal;
                text-decoration: none;
                font-size: 0.8rem;
                transition: .4s;
                color: $realblack;
                cursor: pointer;
                svg{
                    width: 20px;
                    height: 20px;
                    fill: $lightred;
                    margin-right: 20px;
                    transition: .4s;
                }
                .dropdown-name{
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }
                .drop-icon{
                    width: 20px;
                    height: 20px;
                }
            }
            .drop-links{
                width: 100%;
                max-height: 0;
                overflow: hidden;
                padding: 0 0 0 20px;
                opacity: 0;
                transition: .6s;
                &.active{
                    opacity: 1;
                    max-height: 1000px;
                }
            }
        }
        a{
            width: 100%;
            display: flex;
            align-items: center;
            padding: 15px 25px;
            margin: 5px 0;
            border-bottom: 1px solid sal;
            text-decoration: none;
            font-size: 0.8rem;
            transition: .4s;
            color: $realblack;
            &.router-link-active{
                background-color: $lightred;
                color: $white;
                svg{
                    fill: $white;
                }
            }
            svg{
                width: 20px;
                height: 20px;
                fill: $lightred;
                margin-right: 20px;
                transition: .4s;
            }
            &:hover{
                background-color: $lightred;
                color: $white;
                svg{
                    fill: $white;
                }
            }
        }
    }
}
</style>