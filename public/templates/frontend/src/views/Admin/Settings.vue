<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="content">
        <Topbar />
        <Loader v-if="loading" />
        <Modal v-if="modal" :current="form" :type="modalType" @close="closeModal()" @refresh="userInfo()" />
        <div class="detailed-content">
            <h1 class="locator">Settings</h1>
            <div class="tabs">
                <label class="tab" @click="tab = 'profile'" :class="{ active: tab == 'profile' }">Account</label>
                <label class="tab" @click="tab = 'company'" :class="{ active: tab == 'company' }"  v-if="$loggedUser().role.role == 'superadmin' || $loggedUser().role.role == 'admin'">Company Profile</label>
            </div>
            <div class="active" v-if="tab == 'profile'">
                <form class="wrapper-box" @submit.prevent="updateProfile()">
                    <div class="flex-wrap">
                        <div class="profile">
                            <Uploader
                                v-if="admin.image && profile"
                                :multiple="false"
                                :uploadUrl="'files/upload'"
                                @imagesUploaded="(data) =>{ admin.image = data }"
                                :value="admin.image"
                            />
                            <div class="img" v-else>
                                <svg @click="profile = true" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M9.77778 21H14.2222C17.3433 21 18.9038 21 20.0248 20.2646C20.51 19.9462 20.9267 19.5371 21.251 19.0607C22 17.9601 22 16.4279 22 13.3636C22 10.2994 22 8.76721 21.251 7.6666C20.9267 7.19014 20.51 6.78104 20.0248 6.46268C19.3044 5.99013 18.4027 5.82123 17.022 5.76086C16.3631 5.76086 15.7959 5.27068 15.6667 4.63636C15.4728 3.68489 14.6219 3 13.6337 3H10.3663C9.37805 3 8.52715 3.68489 8.33333 4.63636C8.20412 5.27068 7.63685 5.76086 6.978 5.76086C5.59733 5.82123 4.69555 5.99013 3.97524 6.46268C3.48995 6.78104 3.07328 7.19014 2.74902 7.6666C2 8.76721 2 10.2994 2 13.3636C2 16.4279 2 17.9601 2.74902 19.0607C3.07328 19.5371 3.48995 19.9462 3.97524 20.2646C5.09624 21 6.65675 21 9.77778 21Z" fill="#FFF"></path> <path d="M17.5562 9.27246C17.096 9.27246 16.7229 9.63877 16.7229 10.0906C16.7229 10.5425 17.096 10.9088 17.5562 10.9088H18.6673C19.1276 10.9088 19.5007 10.5425 19.5007 10.0906C19.5007 9.63877 19.1276 9.27246 18.6673 9.27246H17.5562Z" fill="#FFF"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0007 9.27246C9.69946 9.27246 7.83398 11.104 7.83398 13.3634C7.83398 15.6227 9.69946 17.4543 12.0007 17.4543C14.3018 17.4543 16.1673 15.6227 16.1673 13.3634C16.1673 11.104 14.3018 9.27246 12.0007 9.27246ZM12.0007 10.9088C10.6199 10.9088 9.50065 12.0078 9.50065 13.3634C9.50065 14.719 10.6199 15.8179 12.0007 15.8179C13.3814 15.8179 14.5007 14.719 14.5007 13.3634C14.5007 12.0078 13.3814 10.9088 12.0007 10.9088Z" fill="#FFF"></path> </g></svg>
                                <img :src="$file(admin.image)" alt="">
                            </div>
                            <div class="info">
                                <h2 class="names">{{ $loggedUser().firstname }} {{ $loggedUser().lastname }}</h2>
                                <p class="role" v-if="admin.role">{{ admin.role.role }}</p>
                            </div>
                        </div>
                        <button class="edit">
                            <svg fill="#905b06" viewBox="-1.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.857 3.882v3.341a1.03 1.03 0 0 1-2.058 0v-.97a5.401 5.401 0 0 0-1.032 2.27 1.03 1.03 0 1 1-2.02-.395A7.462 7.462 0 0 1 2.235 4.91h-.748a1.03 1.03 0 1 1 0-2.058h3.34a1.03 1.03 0 0 1 1.03 1.03zm-3.25 9.237a1.028 1.028 0 0 1-1.358-.523 7.497 7.497 0 0 1-.37-1.036 1.03 1.03 0 1 1 1.983-.55 5.474 5.474 0 0 0 .269.751 1.029 1.029 0 0 1-.524 1.358zm2.905 2.439a1.028 1.028 0 0 1-1.42.322 7.522 7.522 0 0 1-.885-.652 1.03 1.03 0 0 1 1.34-1.563 5.435 5.435 0 0 0 .643.473 1.03 1.03 0 0 1 .322 1.42zm3.68.438a1.03 1.03 0 0 1-1.014 1.044h-.106a7.488 7.488 0 0 1-.811-.044 1.03 1.03 0 0 1 .224-2.046 5.41 5.41 0 0 0 .664.031h.014a1.03 1.03 0 0 1 1.03 1.015zm.034-12.847a1.03 1.03 0 0 1-1.029 1.01h-.033a1.03 1.03 0 0 1 .017-2.06h.017l.019.001a1.03 1.03 0 0 1 1.009 1.05zm3.236 11.25a1.029 1.029 0 0 1-.3 1.425 7.477 7.477 0 0 1-.797.453 1.03 1.03 0 1 1-.905-1.849 5.479 5.479 0 0 0 .578-.328 1.03 1.03 0 0 1 1.424.3zM10.475 3.504a1.029 1.029 0 0 1 1.41-.359l.018.011a1.03 1.03 0 1 1-1.06 1.764l-.01-.006a1.029 1.029 0 0 1-.358-1.41zm4.26 9.445a7.5 7.5 0 0 1-.315.56 1.03 1.03 0 1 1-1.749-1.086 5.01 5.01 0 0 0 .228-.405 1.03 1.03 0 1 1 1.836.93zm-1.959-6.052a1.03 1.03 0 0 1 1.79-1.016l.008.013a1.03 1.03 0 1 1-1.79 1.017zm2.764 2.487a9.327 9.327 0 0 1 0 .366 1.03 1.03 0 0 1-1.029 1.005h-.025A1.03 1.03 0 0 1 13.482 9.7a4.625 4.625 0 0 0 0-.266 1.03 1.03 0 0 1 1.003-1.055h.026a1.03 1.03 0 0 1 1.029 1.004z"></path></g></svg>
                            Update
                        </button>
                    </div>
                </form>
                <h2 class="label">Personal Information</h2>
                <form class="wrapper-box" @submit.prevent="updateProfile()">
                    <div class="flex-wrap">
                        <div class="info">
                            <div class="flex">
                                <div>
                                    <label>First Name</label>
                                    <input type="text" v-model="admin.firstname">
                                </div>
                                <div>
                                    <label>Last Name</label>
                                    <input type="text" v-model="admin.lastname">
                                </div>
                            </div>
                            <div class="flex">
                                <div>
                                    <label>Email</label>
                                    <input type="text" v-model="admin.email">
                                </div>
                                <div>
                                    <label>Working days</label>
                                    <div class="workingdays" @click="openModal('working days', admin)">Working days</div>
                                </div>
                            </div>
                        </div>
                        <button class="edit">
                            <svg fill="#905b06" viewBox="-1.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.857 3.882v3.341a1.03 1.03 0 0 1-2.058 0v-.97a5.401 5.401 0 0 0-1.032 2.27 1.03 1.03 0 1 1-2.02-.395A7.462 7.462 0 0 1 2.235 4.91h-.748a1.03 1.03 0 1 1 0-2.058h3.34a1.03 1.03 0 0 1 1.03 1.03zm-3.25 9.237a1.028 1.028 0 0 1-1.358-.523 7.497 7.497 0 0 1-.37-1.036 1.03 1.03 0 1 1 1.983-.55 5.474 5.474 0 0 0 .269.751 1.029 1.029 0 0 1-.524 1.358zm2.905 2.439a1.028 1.028 0 0 1-1.42.322 7.522 7.522 0 0 1-.885-.652 1.03 1.03 0 0 1 1.34-1.563 5.435 5.435 0 0 0 .643.473 1.03 1.03 0 0 1 .322 1.42zm3.68.438a1.03 1.03 0 0 1-1.014 1.044h-.106a7.488 7.488 0 0 1-.811-.044 1.03 1.03 0 0 1 .224-2.046 5.41 5.41 0 0 0 .664.031h.014a1.03 1.03 0 0 1 1.03 1.015zm.034-12.847a1.03 1.03 0 0 1-1.029 1.01h-.033a1.03 1.03 0 0 1 .017-2.06h.017l.019.001a1.03 1.03 0 0 1 1.009 1.05zm3.236 11.25a1.029 1.029 0 0 1-.3 1.425 7.477 7.477 0 0 1-.797.453 1.03 1.03 0 1 1-.905-1.849 5.479 5.479 0 0 0 .578-.328 1.03 1.03 0 0 1 1.424.3zM10.475 3.504a1.029 1.029 0 0 1 1.41-.359l.018.011a1.03 1.03 0 1 1-1.06 1.764l-.01-.006a1.029 1.029 0 0 1-.358-1.41zm4.26 9.445a7.5 7.5 0 0 1-.315.56 1.03 1.03 0 1 1-1.749-1.086 5.01 5.01 0 0 0 .228-.405 1.03 1.03 0 1 1 1.836.93zm-1.959-6.052a1.03 1.03 0 0 1 1.79-1.016l.008.013a1.03 1.03 0 1 1-1.79 1.017zm2.764 2.487a9.327 9.327 0 0 1 0 .366 1.03 1.03 0 0 1-1.029 1.005h-.025A1.03 1.03 0 0 1 13.482 9.7a4.625 4.625 0 0 0 0-.266 1.03 1.03 0 0 1 1.003-1.055h.026a1.03 1.03 0 0 1 1.029 1.004z"></path></g></svg>
                            Update
                        </button>
                    </div>
                </form>
                <h2 class="label">Security</h2>
                <div class="wrapper-box">
                    <div class="flex-wrap">
                        <form class="security" @submit.prevent="$changePassword()">
                            <div class="flex">
                                <div>
                                    <label>Previous Password</label>
                                    <input type="password" v-model="password_form.previous_password" placeholder="Previous password" required>
                                </div>
                            </div>
                            <div class="flex">
                                <div>
                                    <label>New Password</label>
                                    <input type="password" v-model="password_form.new_password" placeholder="New password" required>
                                </div>
                                <div>
                                    <label>Confirm Password</label>
                                    <input type="password" v-model="password_form.confirm_password" placeholder="Confirm password" required>
                                </div>
                            </div>
                            <button class="btn-submit">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14.89 5.0799C14.02 4.8199 13.06 4.6499 12 4.6499C7.20996 4.6499 3.32996 8.5299 3.32996 13.3199C3.32996 18.1199 7.20996 21.9999 12 21.9999C16.79 21.9999 20.67 18.1199 20.67 13.3299C20.67 11.5499 20.13 9.8899 19.21 8.5099" stroke="#905b06" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16.13 5.32L13.24 2" stroke="#905b06" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M16.13 5.32007L12.76 7.78007" stroke="#905b06" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="active" v-if="tab == 'company'">
                <h2 class="label">Company Logo</h2>
                <form class="wrapper-box" @submit.prevent="updateCompanyProfile()">
                    <div class="flex-wrap">
                        <div class="profile">
                            <Uploader
                                v-if="company.logo && logo"
                                :multiple="false"
                                :uploadUrl="'files/upload'"
                                @imagesUploaded="(data) =>{ company.logo = data }"
                                :value="company.logo"
                            />
                            <div class="img" v-else>
                                <svg @click="logo = true" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path opacity="0.5" d="M9.77778 21H14.2222C17.3433 21 18.9038 21 20.0248 20.2646C20.51 19.9462 20.9267 19.5371 21.251 19.0607C22 17.9601 22 16.4279 22 13.3636C22 10.2994 22 8.76721 21.251 7.6666C20.9267 7.19014 20.51 6.78104 20.0248 6.46268C19.3044 5.99013 18.4027 5.82123 17.022 5.76086C16.3631 5.76086 15.7959 5.27068 15.6667 4.63636C15.4728 3.68489 14.6219 3 13.6337 3H10.3663C9.37805 3 8.52715 3.68489 8.33333 4.63636C8.20412 5.27068 7.63685 5.76086 6.978 5.76086C5.59733 5.82123 4.69555 5.99013 3.97524 6.46268C3.48995 6.78104 3.07328 7.19014 2.74902 7.6666C2 8.76721 2 10.2994 2 13.3636C2 16.4279 2 17.9601 2.74902 19.0607C3.07328 19.5371 3.48995 19.9462 3.97524 20.2646C5.09624 21 6.65675 21 9.77778 21Z" fill="#FFF"></path> <path d="M17.5562 9.27246C17.096 9.27246 16.7229 9.63877 16.7229 10.0906C16.7229 10.5425 17.096 10.9088 17.5562 10.9088H18.6673C19.1276 10.9088 19.5007 10.5425 19.5007 10.0906C19.5007 9.63877 19.1276 9.27246 18.6673 9.27246H17.5562Z" fill="#FFF"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0007 9.27246C9.69946 9.27246 7.83398 11.104 7.83398 13.3634C7.83398 15.6227 9.69946 17.4543 12.0007 17.4543C14.3018 17.4543 16.1673 15.6227 16.1673 13.3634C16.1673 11.104 14.3018 9.27246 12.0007 9.27246ZM12.0007 10.9088C10.6199 10.9088 9.50065 12.0078 9.50065 13.3634C9.50065 14.719 10.6199 15.8179 12.0007 15.8179C13.3814 15.8179 14.5007 14.719 14.5007 13.3634C14.5007 12.0078 13.3814 10.9088 12.0007 10.9088Z" fill="#FFF"></path> </g></svg>
                                <img :src="$file(company.logo)" alt="">
                            </div>
                            <div class="info">
                                <h2 class="names">{{ company.name }}</h2>
                            </div>
                        </div>
                        <button class="edit">
                            <svg fill="#905b06" viewBox="-1.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.857 3.882v3.341a1.03 1.03 0 0 1-2.058 0v-.97a5.401 5.401 0 0 0-1.032 2.27 1.03 1.03 0 1 1-2.02-.395A7.462 7.462 0 0 1 2.235 4.91h-.748a1.03 1.03 0 1 1 0-2.058h3.34a1.03 1.03 0 0 1 1.03 1.03zm-3.25 9.237a1.028 1.028 0 0 1-1.358-.523 7.497 7.497 0 0 1-.37-1.036 1.03 1.03 0 1 1 1.983-.55 5.474 5.474 0 0 0 .269.751 1.029 1.029 0 0 1-.524 1.358zm2.905 2.439a1.028 1.028 0 0 1-1.42.322 7.522 7.522 0 0 1-.885-.652 1.03 1.03 0 0 1 1.34-1.563 5.435 5.435 0 0 0 .643.473 1.03 1.03 0 0 1 .322 1.42zm3.68.438a1.03 1.03 0 0 1-1.014 1.044h-.106a7.488 7.488 0 0 1-.811-.044 1.03 1.03 0 0 1 .224-2.046 5.41 5.41 0 0 0 .664.031h.014a1.03 1.03 0 0 1 1.03 1.015zm.034-12.847a1.03 1.03 0 0 1-1.029 1.01h-.033a1.03 1.03 0 0 1 .017-2.06h.017l.019.001a1.03 1.03 0 0 1 1.009 1.05zm3.236 11.25a1.029 1.029 0 0 1-.3 1.425 7.477 7.477 0 0 1-.797.453 1.03 1.03 0 1 1-.905-1.849 5.479 5.479 0 0 0 .578-.328 1.03 1.03 0 0 1 1.424.3zM10.475 3.504a1.029 1.029 0 0 1 1.41-.359l.018.011a1.03 1.03 0 1 1-1.06 1.764l-.01-.006a1.029 1.029 0 0 1-.358-1.41zm4.26 9.445a7.5 7.5 0 0 1-.315.56 1.03 1.03 0 1 1-1.749-1.086 5.01 5.01 0 0 0 .228-.405 1.03 1.03 0 1 1 1.836.93zm-1.959-6.052a1.03 1.03 0 0 1 1.79-1.016l.008.013a1.03 1.03 0 1 1-1.79 1.017zm2.764 2.487a9.327 9.327 0 0 1 0 .366 1.03 1.03 0 0 1-1.029 1.005h-.025A1.03 1.03 0 0 1 13.482 9.7a4.625 4.625 0 0 0 0-.266 1.03 1.03 0 0 1 1.003-1.055h.026a1.03 1.03 0 0 1 1.029 1.004z"></path></g></svg>
                            Update
                        </button>
                    </div>
                </form>
                <h2 class="label">Company Information</h2>
                <form class="wrapper-box" @submit.prevent="updateCompanyProfile()">
                    <div class="flex-wrap">
                        <div class="info">
                            <div class="flex">
                                <div>
                                    <label>Company Name</label>
                                    <input type="text" v-model="company.name">
                                </div>
                            </div>
                            <div class="flex">
                                <div>
                                    <label>Email</label>
                                    <input type="text" v-model="company.email">
                                </div>
                                <div>
                                    <label>Contact</label>
                                    <input type="text" v-model="company.contacts">
                                </div>
                            </div>
                            <div class="flex">
                                <div>
                                    <label>Address</label>
                                    <input type="text" v-model="company.address">
                                </div>
                                <div>
                                    <label>Whatsapp</label>
                                    <input type="text" v-model="company.whatsapp">
                                </div>
                            </div>
                        </div>
                        <button class="edit">
                            <svg fill="#905b06" viewBox="-1.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.857 3.882v3.341a1.03 1.03 0 0 1-2.058 0v-.97a5.401 5.401 0 0 0-1.032 2.27 1.03 1.03 0 1 1-2.02-.395A7.462 7.462 0 0 1 2.235 4.91h-.748a1.03 1.03 0 1 1 0-2.058h3.34a1.03 1.03 0 0 1 1.03 1.03zm-3.25 9.237a1.028 1.028 0 0 1-1.358-.523 7.497 7.497 0 0 1-.37-1.036 1.03 1.03 0 1 1 1.983-.55 5.474 5.474 0 0 0 .269.751 1.029 1.029 0 0 1-.524 1.358zm2.905 2.439a1.028 1.028 0 0 1-1.42.322 7.522 7.522 0 0 1-.885-.652 1.03 1.03 0 0 1 1.34-1.563 5.435 5.435 0 0 0 .643.473 1.03 1.03 0 0 1 .322 1.42zm3.68.438a1.03 1.03 0 0 1-1.014 1.044h-.106a7.488 7.488 0 0 1-.811-.044 1.03 1.03 0 0 1 .224-2.046 5.41 5.41 0 0 0 .664.031h.014a1.03 1.03 0 0 1 1.03 1.015zm.034-12.847a1.03 1.03 0 0 1-1.029 1.01h-.033a1.03 1.03 0 0 1 .017-2.06h.017l.019.001a1.03 1.03 0 0 1 1.009 1.05zm3.236 11.25a1.029 1.029 0 0 1-.3 1.425 7.477 7.477 0 0 1-.797.453 1.03 1.03 0 1 1-.905-1.849 5.479 5.479 0 0 0 .578-.328 1.03 1.03 0 0 1 1.424.3zM10.475 3.504a1.029 1.029 0 0 1 1.41-.359l.018.011a1.03 1.03 0 1 1-1.06 1.764l-.01-.006a1.029 1.029 0 0 1-.358-1.41zm4.26 9.445a7.5 7.5 0 0 1-.315.56 1.03 1.03 0 1 1-1.749-1.086 5.01 5.01 0 0 0 .228-.405 1.03 1.03 0 1 1 1.836.93zm-1.959-6.052a1.03 1.03 0 0 1 1.79-1.016l.008.013a1.03 1.03 0 1 1-1.79 1.017zm2.764 2.487a9.327 9.327 0 0 1 0 .366 1.03 1.03 0 0 1-1.029 1.005h-.025A1.03 1.03 0 0 1 13.482 9.7a4.625 4.625 0 0 0 0-.266 1.03 1.03 0 0 1 1.003-1.055h.026a1.03 1.03 0 0 1 1.029 1.004z"></path></g></svg>
                            Update
                        </button>
                    </div>
                </form>
                <h2 class="label">About</h2>
                <form class="wrapper-box" @submit.prevent="updateCompanyProfile()">
                    <div class="flex-wrap">
                        <div class="info long">
                            <label>Welcome message</label>
                            <textarea v-model="company.welcome_message" rows="7" cols="100" resize="false"></textarea>
                            <label>Welcome message cover</label>
                            <Uploader
                                v-if="company.welcome_cover"
                                :multiple="false"
                                :uploadUrl="'files/upload'"
                                @imagesUploaded="(data) =>{ company.welcome_cover = data }"
                                :value="company.welcome_cover"
                            />
                            <label>Description</label>
                            <textarea v-model="company.about_description" rows="7" cols="100" resize="false"></textarea>
                            <label>Mission</label>
                            <textarea v-model="company.mission" rows="5" cols="100" resize="false"></textarea>
                            <label>Vision</label>
                            <textarea v-model="company.vision" rows="5" cols="100" resize="false"></textarea>
                            <label>Core values</label>
                            <textarea v-model="company.core_values" placeholder="Core values..." rows="5" cols="100" resize="false"></textarea>
                        </div>
                        <button class="edit">
                            <svg fill="#905b06" viewBox="-1.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.857 3.882v3.341a1.03 1.03 0 0 1-2.058 0v-.97a5.401 5.401 0 0 0-1.032 2.27 1.03 1.03 0 1 1-2.02-.395A7.462 7.462 0 0 1 2.235 4.91h-.748a1.03 1.03 0 1 1 0-2.058h3.34a1.03 1.03 0 0 1 1.03 1.03zm-3.25 9.237a1.028 1.028 0 0 1-1.358-.523 7.497 7.497 0 0 1-.37-1.036 1.03 1.03 0 1 1 1.983-.55 5.474 5.474 0 0 0 .269.751 1.029 1.029 0 0 1-.524 1.358zm2.905 2.439a1.028 1.028 0 0 1-1.42.322 7.522 7.522 0 0 1-.885-.652 1.03 1.03 0 0 1 1.34-1.563 5.435 5.435 0 0 0 .643.473 1.03 1.03 0 0 1 .322 1.42zm3.68.438a1.03 1.03 0 0 1-1.014 1.044h-.106a7.488 7.488 0 0 1-.811-.044 1.03 1.03 0 0 1 .224-2.046 5.41 5.41 0 0 0 .664.031h.014a1.03 1.03 0 0 1 1.03 1.015zm.034-12.847a1.03 1.03 0 0 1-1.029 1.01h-.033a1.03 1.03 0 0 1 .017-2.06h.017l.019.001a1.03 1.03 0 0 1 1.009 1.05zm3.236 11.25a1.029 1.029 0 0 1-.3 1.425 7.477 7.477 0 0 1-.797.453 1.03 1.03 0 1 1-.905-1.849 5.479 5.479 0 0 0 .578-.328 1.03 1.03 0 0 1 1.424.3zM10.475 3.504a1.029 1.029 0 0 1 1.41-.359l.018.011a1.03 1.03 0 1 1-1.06 1.764l-.01-.006a1.029 1.029 0 0 1-.358-1.41zm4.26 9.445a7.5 7.5 0 0 1-.315.56 1.03 1.03 0 1 1-1.749-1.086 5.01 5.01 0 0 0 .228-.405 1.03 1.03 0 1 1 1.836.93zm-1.959-6.052a1.03 1.03 0 0 1 1.79-1.016l.008.013a1.03 1.03 0 1 1-1.79 1.017zm2.764 2.487a9.327 9.327 0 0 1 0 .366 1.03 1.03 0 0 1-1.029 1.005h-.025A1.03 1.03 0 0 1 13.482 9.7a4.625 4.625 0 0 0 0-.266 1.03 1.03 0 0 1 1.003-1.055h.026a1.03 1.03 0 0 1 1.029 1.004z"></path></g></svg>
                            Update
                        </button>
                    </div>
                </form>
                <h2 class="label">Socials medias</h2>
                <form class="wrapper-box" @submit.prevent="updateCompanyProfile()">
                    <div class="flex-wrap">
                        <div class="info long">
                            <div class="flex">
                                <div>
                                    <label>Youtube</label>
                                    <input type="text" v-model="company.youtube">
                                </div>
                                <div>
                                    <label>Instagram</label>
                                    <input type="text" v-model="company.instagram">
                                </div>
                            </div>
                            <div class="flex">
                                <div>
                                    <label>Facebook</label>
                                    <input type="text" v-model="company.facebook">
                                </div>
                            </div>
                        </div>
                        <button class="edit">
                            <svg fill="#905b06" viewBox="-1.5 0 19 19" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M5.857 3.882v3.341a1.03 1.03 0 0 1-2.058 0v-.97a5.401 5.401 0 0 0-1.032 2.27 1.03 1.03 0 1 1-2.02-.395A7.462 7.462 0 0 1 2.235 4.91h-.748a1.03 1.03 0 1 1 0-2.058h3.34a1.03 1.03 0 0 1 1.03 1.03zm-3.25 9.237a1.028 1.028 0 0 1-1.358-.523 7.497 7.497 0 0 1-.37-1.036 1.03 1.03 0 1 1 1.983-.55 5.474 5.474 0 0 0 .269.751 1.029 1.029 0 0 1-.524 1.358zm2.905 2.439a1.028 1.028 0 0 1-1.42.322 7.522 7.522 0 0 1-.885-.652 1.03 1.03 0 0 1 1.34-1.563 5.435 5.435 0 0 0 .643.473 1.03 1.03 0 0 1 .322 1.42zm3.68.438a1.03 1.03 0 0 1-1.014 1.044h-.106a7.488 7.488 0 0 1-.811-.044 1.03 1.03 0 0 1 .224-2.046 5.41 5.41 0 0 0 .664.031h.014a1.03 1.03 0 0 1 1.03 1.015zm.034-12.847a1.03 1.03 0 0 1-1.029 1.01h-.033a1.03 1.03 0 0 1 .017-2.06h.017l.019.001a1.03 1.03 0 0 1 1.009 1.05zm3.236 11.25a1.029 1.029 0 0 1-.3 1.425 7.477 7.477 0 0 1-.797.453 1.03 1.03 0 1 1-.905-1.849 5.479 5.479 0 0 0 .578-.328 1.03 1.03 0 0 1 1.424.3zM10.475 3.504a1.029 1.029 0 0 1 1.41-.359l.018.011a1.03 1.03 0 1 1-1.06 1.764l-.01-.006a1.029 1.029 0 0 1-.358-1.41zm4.26 9.445a7.5 7.5 0 0 1-.315.56 1.03 1.03 0 1 1-1.749-1.086 5.01 5.01 0 0 0 .228-.405 1.03 1.03 0 1 1 1.836.93zm-1.959-6.052a1.03 1.03 0 0 1 1.79-1.016l.008.013a1.03 1.03 0 1 1-1.79 1.017zm2.764 2.487a9.327 9.327 0 0 1 0 .366 1.03 1.03 0 0 1-1.029 1.005h-.025A1.03 1.03 0 0 1 13.482 9.7a4.625 4.625 0 0 0 0-.266 1.03 1.03 0 0 1 1.003-1.055h.026a1.03 1.03 0 0 1 1.029 1.004z"></path></g></svg>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import profilePic from "@/components/Uploader.vue";
import Modal from "./Doctors/components/DoctorModal.vue"
export default {
    name: "AdminSettings",
    components: { profilePic, Modal },
    data() {
        return {
            tab: 'profile',
            loading: false,
            logo: false,
            company: {},
            admin: {},
            profile: false,
            password_form: {
                previous_password: '',
                new_password: '',
                confirm_password: '',
            },
            modal: false,
            modalType: null,
            form: {},
        }
    },
    methods: {
        getAllCompanyProfile(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_WEB_INFO')
            .then((res) => {
                this.company = res.data;
                this.loading = false;
            }).catch(() => {
                this.loading = false;
            })
        },
        openModal(type,content){
            this.modalType = type
            this.modal = !this.modal
            this.form = { ...content }
        },
        closeModal(){
            this.modal = false
            this.modalType = null
        },
        updateProfile(){
            this.loading = true;
            // let action = (this.$loggedUser().role.role == 'admin' || this.$loggedUser().role.role == 'superadmin') ? 'UPDATE_ADMIN' : 'UPDATE_DOCTOR';
            let action = 'UPDATE_ADMIN';
            if(this.$loggedUser().role.role == 'doctor'){
                action = 'UPDATE_DOCTOR';
            }
            this.$store.dispatch(action, this.admin)
            .then((res) => {
                this.loading = false;
                if(res.data.message == 'Profile updated successfully'){
                    localStorage.setItem('logged_user', JSON.stringify(res.data.data))
                    this.profile = false;
                    this.admin = this.$loggedUser();
                    this.$notify({
                        type: 'success',
                        text: res.data.message,
                    })
                }else{
                    this.$notify({
                        type: 'error',
                        text: "Failed to update"
                    })
                }
            }).catch((err) => {
                this.loading = false;
                console.log(err)
            })
        },
        updateCompanyProfile(){
            this.loading = true;
            this.$store.dispatch('UPDATE_WEB_INFO', this.company)
                .then(res =>{
                    this.getAllCompanyProfile();
                    this.logo = false
                    if(res.data.status == "success"){
                        this.$notify({
                            text: res.data.message,
                            type: "success"
                        })
                    }else{
                        this.$notify({
                            text: res.data.message,
                            type: "error"
                        })
                    }
                    this.loading = false;
                })
                .catch(err =>{
                    this.loading = false;
                    console.log(err);
                })
        },
        userInfo(){
            this.admin = this.$loggedUser();
        },
    },
    mounted() {
        this.getAllCompanyProfile();
        this.userInfo();
    },
}
</script>

<style lang="scss" scoped>
@import "../../scss/index.scss";
.detailed-content{
    padding: 20px 20px 0;
    overflow-y: auto;
    height: calc(100vh - 60px);
    .locator{
        font-size: 1.1rem;
        font-weight: 500;
        margin:  0 0 10px;
    }
    .tabs{
        display: flex;
        align-items: center;
        margin: 15px 0px;
        column-gap: 30px;
        .tab{
            font-size: 0.8rem;
            font-weight: 500;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: .6s;
            &:hover{
                background-color: #f1f1f1;
            }
            &.active{
                background-color: #f5a62361;
                color: #905b06;
            }
        }
    }
    .label{
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0 0 10px;
    }
    .wrapper-box{
        border: 1px solid #f7f7f7;
        padding: 15px 20px;
        margin: 0 0 20px;
        border-radius: 7px;
        .flex-wrap{
            display: flex;
            justify-content: space-between;
            align-items: center;
            .profile{
                display: flex;
                align-items: center;
                column-gap: 20px;
                .img{
                    width: 90px;
                    height: 90px;
                    border-radius: 50%;
                    overflow: hidden;
                    position: relative;
                    &::before{
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: #00000061;
                        opacity: 0;
                        transition: .6s;
                    }
                    svg{
                        opacity: 0;
                        transition: .6s;
                        pointer-events: none;
                        position: absolute;
                        cursor: pointer;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        width: 40%;
                        height: 40%;
                    }
                    &:hover{
                        &::before{
                            opacity: 1;
                        }
                        svg{
                            opacity: 1;
                            pointer-events: all;
                        }
                    }
                    img{
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        &.logo{
                            object-fit: contain;
                        }
                    }
                }
                .info{
                    .names{
                        font-size: 0.9rem;
                        font-weight: 500;
                        margin: 0 0 2px;
                    }
                    .role{
                        font-size: 0.75rem;
                        color: #7d7d7d;
                    }
                }
            }
            .edit{
                all: unset;
                background-color: #f5a62361;
                color: #905b06;
                font-size: 0.8rem;
                padding: 5px 15px;
                border-radius: 5px;
                margin: 0 0 0 20px;
                cursor: pointer;
                transition: .6s;
                display: flex;
                align-items: center;
                column-gap: 15px;
                svg{
                    width: 15px;
                    height: 15px;
                }
            }
            .info{
                width: 550px;
                &.long{
                    width: 95%;
                }
                input,textarea{
                    width: 100%;
                    border: 1px solid #dddddd;
                    border-radius: 4px;
                    padding: 7px 15px;
                    margin: 10px 0 0;
                    font-size: 0.8rem;
                    color: #333;
                    &:focus{
                        outline: none;
                        border-color: #f5a623;
                    }
                }
                .flex{
                    display: flex;
                    column-gap: 30px;
                    &:not(:last-child){
                        margin: 0 0 20px;
                    }
                    div{
                        width: 50%;
                        overflow: hidden;
                        label{
                            font-size: 0.9rem;
                            font-weight: 500;
                            display: block;
                            margin: 0 0 4px;
                        }
                        input,textarea{
                            width: 100%;
                            border: 1px solid #dddddd;
                            border-radius: 4px;
                            padding: 7px 15px;
                            font-size: 0.8rem;
                            color: #333;
                            &:focus{
                                outline: none;
                                border-color: #f5a623;
                            }
                        }
                        .workingdays{
                            width: 100%;
                            border-radius: 4px;
                            padding: 7px 15px;
                            margin: 15px 0 0;
                            font-size: 0.8rem;
                            color: #0d5786;
                            text-align: center;
                            background-color: #7cd6de;
                            cursor: pointer;
                        }
                        p{
                            font-size: 0.8rem;
                            color: #7d7d7d;
                            &.description{
                                display: -webkit-box;
                                -webkit-line-clamp: 4;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-overflow: ellipsis;
                            }
                            &.preview{
                                cursor: pointer;
                                display: flex;
                                align-items: center;
                                column-gap: 10px;
                                svg{
                                    width: 20px;
                                    height: 20px;
                                }
                            }
                        }
                        a{
                            margin: 10px 0 0;
                            text-decoration: none;
                            font-size: 0.75rem;
                            color: #7d7d7d;
                            display: -webkit-box;
                            -webkit-line-clamp: 1;
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                    }
                }
            }
            .security{
                width: 500px;
                .flex{
                    display: flex;
                    column-gap: 30px;
                    width: 100%;
                    &:not(:last-child){
                        margin: 0 0 20px;
                    }
                    div{
                        width: 100%;
                        label{
                            font-size: 0.9rem;
                            font-weight: 500;
                            color: #333;
                            display: block;
                            margin: 0 0 5px;
                        }
                        input{
                            width: 100%;
                            border: 1px solid #dddddd;
                            border-radius: 4px;
                            padding: 7px 15px;
                            font-size: 0.8rem;
                            color: #333;
                            &:focus{
                                outline: none;
                                border-color: #f5a623;
                            }
                        }
                    }
                }
                .btn-submit{
                    all: unset;
                    background-color: #f5a62361;
                    color: #905b06;
                    font-size: 0.8rem;
                    padding: 7px 0;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: .6s;
                    display: flex;
                    align-items: center;
                    width: 100%;
                    column-gap: 15px;
                    justify-content: center;
                    svg{
                        width: 15px;
                        height: 15px;
                    }
                }
            }
        }
    }
}
</style>