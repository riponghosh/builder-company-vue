import Vue from 'vue'
import Router from 'vue-router'

import Main from '@/components/main/Main.vue'

import Login from '@/components/main/login/Login.vue'
import Signup from '@/components/main/login/Signup.vue'
import Activate from '@/components/main/login/Activate.vue'

import Home from '@/components/main/home/Home.vue'

import Jobs from '@/components/main/job/Jobs.vue'
import Job from '@/components/main/job/Job.vue'
import JobEdit from '@/components/main/job/JobEdit.vue'

import Artists from '@/components/main/artist/Artists.vue'
import Artist from '@/components/main/artist/Artist.vue'
import ArtistEdit from '@/components/main/artist/ArtistEdit.vue'
import ArtistHome from '@/components/main/artist/ArtistHome.vue'

import Employer from '@/components/main/employer/Employer.vue'
import EmployerEdit from '@/components/main/employer/EmployerEdit.vue'
import EmployerHome from '@/components/main/employer/EmployerHome.vue'

import OneStop from '@/components/main/one-stop/OneStop.vue'
import AboutUs from '@/components/main/about-us/AboutUs.vue'

import User from '@/components/user/User.vue'

import AppliedArtists from '@/components/user/applied-artists/AppliedArtists.vue'
import AppliedJobs from '@/components/user/applied-jobs/AppliedJobs.vue'
import OpenJob from '@/components/user/open-jobs/OpenJob.vue'

import SavedArtists from '@/components/user/saved-artists/SavedArtists.vue'
import SavedJobs from '@/components/user/saved-jobs/SavedJobs.vue'
import ArchivedJobs from '@/components/user/archived-jobs/ArchivedJobs.vue'
import Payment from '@/components/user/payment/Payment.vue'
import Notifications from '@/components/user/notifications/Notifications.vue'
import Calendar from '@/components/user/calendar/Calendar.vue'
import Assistant from '@/components/user/assistant/Assistant.vue'
import Settings from '@/components/user/settings/Settings.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/user',
      component: User,
      children: [
        {
          path: '/',
          redirect: '/user/settings',
        },
        {
          path: 'open-jobs/:id',
          component: OpenJob,
        },
        {
          path: 'applied-artists/:id',
          component: AppliedArtists,
        },
        {
          path: 'applied-jobs/:id',
          component: AppliedJobs,
        },
        {
          path: 'saved-artists',
          component: SavedArtists,
        },
        {
          path: 'archived-jobs',
          component: ArchivedJobs,
        },
        {
          path: 'payment',
          component: Payment,
        },
        {
          path: 'notifications',
          component: Notifications,
        },
        {
          path: 'calendar',
          component: Calendar,
        },
        {
          path: 'assistant',
          component: Assistant,
        },
        {
          path: 'settings',
          component: Settings,
        },
        {
          path: '*',
          redirect: '/user/settings',
        },
      ],
    },
    {
      path: '/',
      component: Main,
      children: [
        {
          path: '/post-job',
          component: JobEdit,
        }, {
          path: '/jobs/:id/edit',
          component: JobEdit,
        }, {
          path: '/jobs/:id',
          component: Job,
        }, {
          path: '/jobs',
          component: Jobs,
        },

        {
          path: '/artists/:id/edit',
          component: ArtistEdit,
        }, {
          path: '/artists/:id',
          component: Artist,
        }, {
          path: '/artists',
          component: Artists,
        }, {
          path: '/artists-home',
          component: ArtistHome,
        },

        {
          path: '/employers/:id/edit',
          component: EmployerEdit,
        }, {
          path: '/employers/:id',
          component: Employer,
        }, {
          path: '/employers-home',
          component: EmployerHome,
        },

        {
          path: '/',
          component: Home,
        }, {
          path: '/login',
          component: Login,
        }, {
          path: '/signup',
          component: Signup,
        }, {
          path: '/Activate/:id/:authKey',
          component: Activate,
        }, {
          path: '/one-stop-service',
          component: OneStop,
        }, {
          path: '/about-us',
          component: AboutUs,
        },
      ],
    },
  ],
})
