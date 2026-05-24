<template>
  <div class="dashboardContent">
    <Sidebar />
    <div class="contents">
        <Topbar />
        <Loader v-if="loading" />
        <div class="detailed-content">
            <h1 class="locator">Dashboard</h1>
            <div class="statistics" v-if="dashboard">
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="0" fill="none" width="20" height="20"></rect> <g> <path d="M16.95 2.58c1.96 1.95 1.96 5.12 0 7.07-1.51 1.51-3.75 1.84-5.59 1.01l-1.87 3.31-2.99.31L5 18H2l-1-2 7.95-7.69c-.92-1.87-.62-4.18.93-5.73 1.95-1.96 5.12-1.96 7.07 0zm-2.51 3.79c.74 0 1.33-.6 1.33-1.34 0-.73-.59-1.33-1.33-1.33-.73 0-1.33.6-1.33 1.33 0 .74.6 1.34 1.33 1.34z"></path> </g> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Admins</h3>
                        <h1 v-if="dashboard.admins ">{{ dashboard.admins }}</h1>
                        <h1 v-else>N/A</h1>
                    </div>
                </div>
                <div class="statistic">
                    <div class="icon">
                        <svg version="1.1" baseProfile="tiny" id="Layer_1" xmlns:x="&amp;ns_extend;" xmlns:i="&amp;ns_ai;" xmlns:graph="&amp;ns_graphs;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" viewBox="0 0 42 42" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M29.609,39h0.781c4.959-0.07,9.689-0.6,10.539-1.391c0.211-1.719,0.45-2.549-7.57-6.17 c-1.141-0.609-0.529-2.969-0.529-2.969c2.411-1.74,4.062-5.761,4.062-8.991c0-5.57-2.633-8.21-6.502-8.48h-0.781 c-3.868,0.27-6.5,2.9-6.5,8.48c0,3.23,1.65,7.25,4.062,8.991c0,0,0.61,2.359-0.528,2.969c-8.021,3.621-7.782,4.451-7.571,6.17 C19.92,38.4,24.65,38.93,29.609,39z M11.608,31h0.782c4.959-0.07,9.689-0.6,10.54-1.391c0.211-1.719,0.449-2.549-7.571-6.17 c-1.14-0.609-0.529-2.969-0.529-2.969c2.41-1.74,4.061-5.76,4.061-8.99c0-5.57-2.631-8.21-6.5-8.48h-0.782 c-3.869,0.27-6.5,2.9-6.5,8.48c0,3.23,1.65,7.25,4.061,8.99c0,0,0.61,2.36-0.529,2.969c-8.021,3.621-7.781,4.451-7.57,6.17 C1.919,30.4,6.649,30.93,11.608,31z"></path> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Patients</h3>
                        <h1 v-if="dashboard.patients">{{ dashboard.patients }}</h1>
                        <h1 v-else>N/A</h1>
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.66749 3.15144C5.88138 3.9264 5.57692 5.0991 4.96802 7.44451L4.88378 7.76897C4.05598 10.9576 3.64207 12.5519 4.39389 13.6719C4.46887 13.7837 4.55129 13.8902 4.64058 13.9909C5.5358 15 7.18295 15 10.4772 15H11.2559V21.25H9.00586C8.59165 21.25 8.25586 21.5858 8.25586 22C8.25586 22.4142 8.59165 22.75 9.00586 22.75H15.0059C15.4201 22.75 15.7559 22.4142 15.7559 22C15.7559 21.5858 15.4201 21.25 15.0059 21.25H12.7559V15H13.5358C14.8551 15 15.9102 15 16.7586 14.9352C16.7568 14.9565 16.7559 14.9782 16.7559 15V17C16.7559 17.4142 17.0916 17.75 17.5059 17.75C17.9201 17.75 18.2559 17.4142 18.2559 17V15V14.6817C18.7241 14.5324 19.0866 14.3131 19.3724 13.9909C19.4617 13.8902 19.5441 13.7837 19.6191 13.6719C20.3709 12.5519 19.957 10.9576 19.1292 7.76898L19.045 7.44451C18.4361 5.0991 18.1316 3.9264 17.3455 3.15144C17.1176 2.92678 16.8636 2.73028 16.5889 2.56616C15.6412 2 14.4297 2 12.0065 2C9.58334 2 8.37176 2 7.42412 2.56616C7.14941 2.73028 6.89538 2.92678 6.66749 3.15144Z"></path> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Services</h3>
                        <h1 v-if="dashboard.services">{{ dashboard.services }}</h1>
                        <h1 v-else>N/A</h1>
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><g> <path class="st0" d="M435.95,287.525c32.51,0,58.87-26.343,58.87-58.853c0-32.51-26.361-58.871-58.87-58.871 c-32.502,0-58.863,26.361-58.863,58.871C377.088,261.182,403.448,287.525,435.95,287.525z"></path> <path class="st0" d="M511.327,344.251c-2.623-15.762-15.652-37.822-25.514-47.677c-1.299-1.306-7.105-1.608-8.673-0.636 c-11.99,7.374-26.074,11.714-41.19,11.714c-15.099,0-29.184-4.34-41.175-11.714c-1.575-0.972-7.373-0.67-8.672,0.636 c-2.757,2.757-5.765,6.427-8.698,10.683c7.935,14.94,14.228,30.81,16.499,44.476c2.27,13.7,1.533,26.67-2.138,38.494 c13.038,4.717,28.673,6.787,44.183,6.787C476.404,397.014,517.804,382.987,511.327,344.251z"></path> <path class="st0" d="M254.487,262.691c52.687,0,95.403-42.716,95.403-95.402c0-52.67-42.716-95.386-95.403-95.386 c-52.678,0-95.378,42.716-95.378,95.386C159.109,219.975,201.808,262.691,254.487,262.691z"></path> <path class="st0" d="M335.269,277.303c-2.07-2.061-11.471-2.588-14.027-1.006c-19.448,11.966-42.271,18.971-66.755,18.971 c-24.466,0-47.3-7.005-66.738-18.971c-2.555-1.583-11.956-1.055-14.026,1.006c-16.021,16.004-37.136,51.782-41.384,77.288 c-10.474,62.826,56.634,85.508,122.148,85.508c65.532,0,132.639-22.682,122.165-85.508 C372.404,329.085,351.289,293.307,335.269,277.303z"></path> <path class="st0" d="M76.049,287.525c32.502,0,58.862-26.343,58.862-58.853c0-32.51-26.36-58.871-58.862-58.871 c-32.511,0-58.871,26.361-58.871,58.871C17.178,261.182,43.538,287.525,76.049,287.525z"></path> <path class="st0" d="M115.094,351.733c2.414-14.353,9.225-31.253,17.764-46.88c-2.38-3.251-4.759-6.083-6.955-8.279 c-1.299-1.306-7.097-1.608-8.672-0.636c-11.991,7.374-26.076,11.714-41.182,11.714c-15.108,0-29.202-4.34-41.183-11.714 c-1.568-0.972-7.382-0.67-8.681,0.636c-9.887,9.854-22.882,31.915-25.514,47.677c-6.468,38.736,34.924,52.762,75.378,52.762 c14.437,0,29.016-1.777,41.459-5.84C113.587,379.108,112.757,365.835,115.094,351.733z"></path> </g> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Doctors</h3>
                        <h1>{{ dashboard.doctors }}</h1>
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'doctor' || $loggedUser().role.role == 'customer-care'">
                    <div class="icon">
                        <svg height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><g> <path class="st0" d="M435.95,287.525c32.51,0,58.87-26.343,58.87-58.853c0-32.51-26.361-58.871-58.87-58.871 c-32.502,0-58.863,26.361-58.863,58.871C377.088,261.182,403.448,287.525,435.95,287.525z"></path> <path class="st0" d="M511.327,344.251c-2.623-15.762-15.652-37.822-25.514-47.677c-1.299-1.306-7.105-1.608-8.673-0.636 c-11.99,7.374-26.074,11.714-41.19,11.714c-15.099,0-29.184-4.34-41.175-11.714c-1.575-0.972-7.373-0.67-8.672,0.636 c-2.757,2.757-5.765,6.427-8.698,10.683c7.935,14.94,14.228,30.81,16.499,44.476c2.27,13.7,1.533,26.67-2.138,38.494 c13.038,4.717,28.673,6.787,44.183,6.787C476.404,397.014,517.804,382.987,511.327,344.251z"></path> <path class="st0" d="M254.487,262.691c52.687,0,95.403-42.716,95.403-95.402c0-52.67-42.716-95.386-95.403-95.386 c-52.678,0-95.378,42.716-95.378,95.386C159.109,219.975,201.808,262.691,254.487,262.691z"></path> <path class="st0" d="M335.269,277.303c-2.07-2.061-11.471-2.588-14.027-1.006c-19.448,11.966-42.271,18.971-66.755,18.971 c-24.466,0-47.3-7.005-66.738-18.971c-2.555-1.583-11.956-1.055-14.026,1.006c-16.021,16.004-37.136,51.782-41.384,77.288 c-10.474,62.826,56.634,85.508,122.148,85.508c65.532,0,132.639-22.682,122.165-85.508 C372.404,329.085,351.289,293.307,335.269,277.303z"></path> <path class="st0" d="M76.049,287.525c32.502,0,58.862-26.343,58.862-58.853c0-32.51-26.36-58.871-58.862-58.871 c-32.511,0-58.871,26.361-58.871,58.871C17.178,261.182,43.538,287.525,76.049,287.525z"></path> <path class="st0" d="M115.094,351.733c2.414-14.353,9.225-31.253,17.764-46.88c-2.38-3.251-4.759-6.083-6.955-8.279 c-1.299-1.306-7.097-1.608-8.672-0.636c-11.991,7.374-26.076,11.714-41.182,11.714c-15.108,0-29.202-4.34-41.183-11.714 c-1.568-0.972-7.382-0.67-8.681,0.636c-9.887,9.854-22.882,31.915-25.514,47.677c-6.468,38.736,34.924,52.762,75.378,52.762 c14.437,0,29.016-1.777,41.459-5.84C113.587,379.108,112.757,365.835,115.094,351.733z"></path> </g> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Appointments</h3>
                        <h1>{{ dashboard.appointments }}</h1>
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" d="M2 6a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V6zm5 1a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H7zm1 4V9h2v2H8zm7-4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2zm0 4a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2zm-8 4a1 1 0 1 0 0 2h10a1 1 0 1 0 0-2H7z" clip-rule="evenodd"></path></g></svg>
                    </div>
                    <div class="details">
                        <h3>Updates</h3>
                        <h1 v-if="dashboard.updates">{{ dashboard.updates }}</h1>
                        <h1 v-else>N/A</h1>
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg class="nofill" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path fill="none" d="M0 0h24v24H0z"></path> <path d="M2 22a8 8 0 1 1 16 0H2zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm10 4h4v2h-4v-2zm-3-5h7v2h-7v-2zm2-5h5v2h-5V7z"></path> </g> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Contacts</h3>
                        <h1>{{ dashboard.contacts }}</h1>
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 0a2 2 0 0 0-1.81 1.15L7.556 6.758 1.7 7.642a2 2 0 0 0-1.13 3.374l4.3 4.408-1.02 6.235a2 2 0 0 0 2.94 2.073L12 20.86l5.216 2.89a2 2 0 0 0 2.942-2.073l-1.02-6.237 4.293-4.39a2 2 0 0 0-1.124-3.376l-5.857-.9-2.64-5.624A2 2 0 0 0 12 0z"></path> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Subscribers</h3>
                        <h1>{{ dashboard.subscribers }}</h1>
                        <!-- <h1 v-else>N/A</h1> -->
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 0a2 2 0 0 0-1.81 1.15L7.556 6.758 1.7 7.642a2 2 0 0 0-1.13 3.374l4.3 4.408-1.02 6.235a2 2 0 0 0 2.94 2.073L12 20.86l5.216 2.89a2 2 0 0 0 2.942-2.073l-1.02-6.237 4.293-4.39a2 2 0 0 0-1.124-3.376l-5.857-.9-2.64-5.624A2 2 0 0 0 12 0z"></path> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Partners</h3>
                        <h1>{{ dashboard.partners }}</h1>
                    </div>
                </div>
                <div class="statistic" v-if="$loggedUser().role.role == 'superadmin'">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g stroke-width="0"></g><g stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 0a2 2 0 0 0-1.81 1.15L7.556 6.758 1.7 7.642a2 2 0 0 0-1.13 3.374l4.3 4.408-1.02 6.235a2 2 0 0 0 2.94 2.073L12 20.86l5.216 2.89a2 2 0 0 0 2.942-2.073l-1.02-6.237 4.293-4.39a2 2 0 0 0-1.124-3.376l-5.857-.9-2.64-5.624A2 2 0 0 0 12 0z"></path> </g></svg>
                    </div>
                    <div class="details">
                        <h3>Departments</h3>
                        <h1>{{ dashboard.departments }}</h1>
                        <!-- <h1 v-else>N/A</h1> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "AdminDashboard",
    data() {
        return {
            loading: false,
            dashboard: []
        }
    },
    methods:{
        getDashboardData(){
            this.loading = true
            this.$store.dispatch('GET_ALL_DASHBOARD_INFO')
                .then(res=>{
                    this.loading = false
                    this.dashboard = res.data
                })
                .catch(err=>{
                    this.loading = false
                })
        }
    },
    mounted(){
        this.$checkAuth()
        this.getDashboardData()
    }
}
</script>

<style lang="scss" scoped>
@import "../../scss/index.scss";
.detailed-content{
    padding: 20px;
    .locator{
        font-size: 1.1rem;
        font-weight: 500;
        margin:  0 0 30px;
    }
    .statistics{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 40px;
        .statistic{
            display: flex;
            align-items: center;
            border-radius: 5px;
            background-color: #feaea069;
            overflow: hidden;
            border: 1px solid #ffb4a785;
            // box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
            .icon{
                width: 100px;
                height: 90px;
                position: relative;
                background-color: $white;
                flex-shrink: 0;
                svg{
                    width: 30%;
                    height: 30%;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    path{
                        fill: $lightred;
                        &.nofill{
                            all: unset;
                        }
                    }
                }
            }
            .details{
                display: flex;
                flex-direction: column;
                row-gap: 10px;
                width: 100%;
                text-align: center;
                color: $lightred;
                h3{
                    font-size: 0.8rem;
                    font-weight: 500;
                }
                h1{
                    font-size: 1.2rem;
                    font-weight: 700;
                }
            }
        }
    }
}
</style>