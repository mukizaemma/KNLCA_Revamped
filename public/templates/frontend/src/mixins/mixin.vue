<script>
export default {
    methods: {
        $file(filename){
            return this.$store.state.apiUploadUrl + filename
        },
        $loggedUser(){
            return JSON.parse(localStorage.getItem('logged_user'));
        },
        $checkAuth(){
            if(!this.$loggedUser() || this.$loggedUser().role.role == 'patient') {
                this.$router.push("/login");
            }
        },
        $getAllDepartments(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_DEPARTMENTS')
                .then(res =>{
                    this.loading = false;
                    this.departments = res.data;
                })
                .catch(err =>{
                    this.loading = false;
                    console.log(err);
                })
        },
        $getAllArticles(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_UPDATES')
                .then(res =>{
                    this.loading = false;
                    this.articles = res.data;
                })
                .catch(err =>{
                    this.loading = false;
                    console.log(err);
                })
        },
        $getMinDate(){
            return new Date().toISOString().split('T')[0]
        },
        $getAllDoctors(){
            this.loading = true
            this.$store.dispatch('GET_ALL_DOCTORS')
                .then(res => {
                    this.loading = false
                    res.data.forEach(doctor => {
                        doctor.working_days = JSON.parse(doctor.working_days)
                    });
                    this.doctors = res.data
                    this.me = 'haha'
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        },
        $getAllServices(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_SERVICES')
                .then(res =>{
                    this.loading = false;
                    this.services = res.data;
                })
                .catch(err =>{
                    this.loading = false;
                    console.log(err);
                })
        },
        $getAllPartners(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_PARTNERS')
                .then(res =>{
                    this.loading = false;
                    this.partners = res.data;
                })
                .catch(err =>{
                    this.loading = false;
                    console.log(err);
                })
        },
        $getAllDoctors(){
            this.loading = true;
            this.$store.dispatch('GET_ALL_DOCTORS')
                .then(res =>{
                    this.loading = false;
                    this.team = res.data;
                })
                .catch(err =>{
                    this.loading = false;
                    console.log(err);
                })
        },
        $getAllSlides(){
            this.loading = true
            this.$store.dispatch('GET_ALL_SLIDES')
                .then(res => {
                    this.loading = false
                    this.slides = res.data
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        },
        $changePassword(){
            if(this.password_form.new_password != this.password_form.confirm_password){
                this.$notify({
                    text: "New and Confirm Password does not match",
                    type: "error"
                })
                return;
            } else {
                this.loading = true;
                this.$store.dispatch('CHANGE_PASSWORD', this.password_form)
                    .then(res =>{
                        this.loading = false;
                        this.$notify({
                            text: res.data.message,
                            type: "success"
                        })
                        this.password_form = {
                            previous_password: '',
                            new_password: '',
                            confirm_password: ''
                        }
                    })
                    .catch(err =>{
                        this.loading = false;
                        console.log(err);
                    })
            }
        },
        $getGallery(place){
            this.loading = true;
            this.$store.dispatch('GET_GALLERY')
            .then(res => {
                this.loading = false;
                place ? this.gallery = res.data.filter(image => image.active_status == 1) : this.gallery = res.data;
            }).catch(err => {
                this.loading = false;
                console.log(err)
            })
        },
        $getAllStaff(place){
            this.loading = true
            this.$store.dispatch('GET_ALL_STAFF')
                .then(res => {
                    this.loading = false
                    place ? this.staff = res.data.filter(member => member.active_status == 1) : this.staff = res.data
                })
                .catch(err => {
                    this.loading = false
                    console.log(err)
                })
        }
    }
}
</script>