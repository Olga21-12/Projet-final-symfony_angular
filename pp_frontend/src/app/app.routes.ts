import { Routes } from '@angular/router';
import { RegisterComponent } from './pages/register/register.component';
import { LoginComponent } from './pages/login/login.component';
import { FaqComponent } from './pages/faq/faq.component';
import { ContactComponent } from './pages/contact/contact.component';
import { HomeComponent } from './pages/home/home.component';
import { ProfileComponent } from './pages/profile/profile.component';
import { VerifyEmailComponent } from './components/verify-email/verify-email.component';

export const routes: Routes = [
    { path: '', component: HomeComponent, title: 'Accueil' },
    { path: 'contact', component: ContactComponent, title: 'Contacts' },
    { path: 'faq', component: FaqComponent, title: 'FAQ' },
    { path: 'login', component: LoginComponent, title: 'Login' },
    { path: 'register', component: RegisterComponent, title: 'S\'inscrire' },
    { path: 'profile', component: ProfileComponent, title: 'Profile' },
    { path: 'verify-email', component: VerifyEmailComponent, title: 'Vérification Email' }
];
