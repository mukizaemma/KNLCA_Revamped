import { createRouter, createWebHistory } from 'vue-router'

// Site
import Home from '@/views/Site/Home.vue'
import About from '@/views/Site/About.vue'
import Contact from '@/views/Site/Contact.vue'
import Departments from '@/views/Site/Departments.vue'
import LeadershipTeam from '@/views/Site/LeadershipTeam.vue'
import Blog from '@/views/Site/Blog.vue'
import Appointment from '@/views/Site/Appointment.vue'
import Article from '@/views/Site/Article.vue'
import Department from '@/views/Site/Department.vue'
import Doctors from '@/views/Site/Doctors.vue'
import Doctor from '@/views/Site/Doctor.vue'
import Gallery from '@/views/Site/Gallery.vue'
// User
import Profile from '@/views/User/Profile.vue'
// Dashboard
import Login from '@/views/Dashboard/Login.vue'
// Admin
import AdminDashboard from '@/views/Admin/Dashboard.vue'
import AdminAdmins from '@/views/Admin/Admins/Admins.vue'
import AdminSlides from '@/views/Admin/Slides/Slides.vue'
import AdminDepartments from '@/views/Admin/Departments/Departments.vue'
import AdminServices from '@/views/Admin/Services/Services.vue'
import AdminUpdates from '@/views/Admin/Updates/Update.vue'
import AdminDoctors from '@/views/Admin/Doctors/Doctors.vue'
import AdminPartners from '@/views/Admin/Partners/Partners.vue'
import AdminGallery from '@/views/Admin/Gallery/Gallery.vue'
import Staff from '@/views/Admin/Staff/Staff.vue'
import AdminContacts from '@/views/Admin/Contacts/Contacts.vue'
import AdminSubscribers from '@/views/Admin/Subscribers/Subscribers.vue'
import AdminSuggestions from '@/views/Admin/Suggestions/Suggestions.vue'
import Settings from '@/views/Admin/Settings.vue'
// Doctors
import DoctorAppointments from '@/views/Doctors/Appointments/Appointments.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/about',
    name: 'about',
    component: About
  },
  {
    path: '/contact',
    name: 'contact',
    component: Contact
  },
  {
    path: '/departments',
    name: 'departments',
    component: Departments
  },
  {
    path: '/departments/:id/:name',
    name: 'department',
    component: Department
  },
  {
    path: '/leadership-team',
    name: 'LeadershipTeam',
    component: LeadershipTeam
  },
  {
    path: '/doctors',
    name: 'doctors',
    component: Doctors
  },
  {
    path: '/doctors/:id/:slug',
    name: 'doctor',
    component: Doctor
  },
  {
    path: '/updates',
    name: 'updates',
    component: Blog
  },
  {
    path: '/gallery',
    name: 'gallery',
    component: Gallery
  },
  {
    path: '/blog/:slug',
    name: 'article',
    component: Article
  },
  {
    path: '/appointment',
    name: 'appointment',
    component: Appointment
  },
  {
    path: '/profile',
    name: 'profile',
    component: Profile
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/dashboard/overview',
    name: 'AdminDashboard',
    component: AdminDashboard
  },
  {
    path: '/admin/admins',
    name: 'AdminAdmins',
    component: AdminAdmins
  },
  {
    path: '/admin/slides',
    name: 'AdminSlides',
    component: AdminSlides
  },
  {
    path: '/admin/departments',
    name: 'AdminDepartments',
    component: AdminDepartments
  },
  {
    path: '/admin/services',
    name: 'AdminServices',
    component: AdminServices
  },
  {
    path: '/dashboard/appointments',
    name: 'DoctorAppointments',
    component: DoctorAppointments
  },
  {
    path: '/admin/updates',
    name: 'AdminUpdates',
    component: AdminUpdates
  },
  {
    path: '/dashboard/doctors',
    name: 'AdminDoctors',
    component: AdminDoctors
  },
  {
    path: '/dashboard/staff',
    name: 'Staff',
    component: Staff
  },
  {
    path: '/admin/partners',
    name: 'AdminPartners',
    component: AdminPartners
  },
  {
    path: '/admin/gallery',
    name: 'AdminGallery',
    component: AdminGallery
  },
  {
    path: '/admin/contacts',
    name: 'AdminContacts',
    component: AdminContacts
  },
  {
    path: '/admin/subscribers',
    name: 'AdminSubscribers',
    component: AdminSubscribers
  },
  {
    path: '/admin/suggestions',
    name: 'AdminSuggestions',
    component: AdminSuggestions
  },
  {
    path: '/admin/settings',
    name: 'Settings',
    component: Settings
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
