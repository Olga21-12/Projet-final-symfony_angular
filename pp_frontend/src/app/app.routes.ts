import { Routes } from '@angular/router';
import { RegisterComponent } from './pages/register/register.component';
import { LoginComponent } from './pages/login/login.component';
import { FaqComponent } from './pages/faq/faq.component';
import { ContactComponent } from './pages/contact/contact.component';
import { HomeComponent } from './pages/home/home.component';
import { ProfileComponent } from './pages/profile/profile.component';
import { VerifyEmailComponent } from './components/verify-email/verify-email.component';
import { EditProfileComponent } from './components/edit-profile/edit-profile.component';
import { BienListComponent } from './pages/bien-list/bien-list.component';
import { BienDetailComponent } from './pages/bien-detail/bien-detail.component';

export const routes: Routes = [
    { path: '', component: HomeComponent, title: 'Accueil' },
    { path: 'contact', component: ContactComponent, title: 'Contacts' },
    { path: 'faq', component: FaqComponent, title: 'FAQ' },
    { path: 'login', component: LoginComponent, title: 'Login' },
    { path: 'register', component: RegisterComponent, title: 'S\'inscrire' },
    { path: 'profile', component: ProfileComponent, title: 'Profile' },
    { path: 'verify-email', component: VerifyEmailComponent, title: 'Vérification Email' },
    { path: 'edit-profile', component: EditProfileComponent, title: 'Modifier le profil' },
    { path: 'biens', component: BienListComponent, title: 'Liste des Biens' },
    { path: 'biens/:id', component: BienDetailComponent, title: 'Détails du Bien' }

];
