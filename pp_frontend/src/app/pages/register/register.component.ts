import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Router } from '@angular/router'; // Le "Router" d’Angular permet de naviguer entre les pages

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [CommonModule, FormsModule, HttpClientModule],
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
  email = '';
  password = '';
  confirmPassword = '';
  nom = '';
  prenom = '';
  surnom = '';
  date_de_naissance = '';
  pays = '';
  ville = '';
  adresse = '';
  telephone = '';
  photo: File | null = null;

  role = 'ROLE_CLIENT';

  message = '';
  error = '';

  paysList: string[] = [];
  villes: any[] = [];
  selectedPays: string = '';
  selectedVille: string = '';

  agreeTerms = false;

  constructor(private http: HttpClient, private router: Router) {}

  ngOnInit(): void {
  // Charger la liste des pays
  this.http.get('https://127.0.0.1:8000/api/pays').subscribe({
    next: (res: any) => this.paysList = res,
    error: (err) => console.error('Erreur chargement pays', err)
  });
}

// Quand l’utilisateur choisit un pays, on charge les villes correspondantes
onPaysChange(event: any): void {
  const pays = event.target.value;
  this.selectedPays = pays;
  this.villes = []; // on réinitialise la liste
  this.selectedVille = '';

  if (pays) {
    this.http.get(`https://127.0.0.1:8000/api/villes?pays=${encodeURIComponent(pays)}`).subscribe({
      next: (res: any) => this.villes = res,
      error: (err) => console.error('Erreur chargement villes', err)
    });
  }
}

  // traitement de sélection de fichiers
  onFileChange(event: any): void {
    const file = event.target.files[0];
    if (file) this.photo = file;
  }

  register() {

    // Cette fonction est appelée quand l’utilisateur clique sur le bouton "S’inscrire".
    // Elle gère toute la logique de validation et d’envoi des données.
    
    if (this.password !== this.confirmPassword) {
      this.error = 'Les mots de passe ne correspondent pas.';
      return;
    }

    if (!this.agreeTerms) {
      this.error = 'Veuillez accepter les conditions générales.';
      return;
    }

    const formData = new FormData();

    // On crée un objet FormData, très pratique pour envoyer des fichiers + du texte.
    // Il permet d’envoyer des données "multipart/form-data" au serveur Symfony.

    // On ajoute chaque champ du formulaire au FormData.
    formData.append('email', this.email);
    formData.append('password', this.password);
    formData.append('nom', this.nom);
    formData.append('prenom', this.prenom);
    formData.append('surnom', this.surnom);
    formData.append('date_de_naissance', this.date_de_naissance);
    formData.append('adresse', this.adresse);
    formData.append('telephone', this.telephone);
    formData.append('ville', this.selectedVille);
    formData.append('pays', this.selectedPays);
    formData.append('role', this.role);
    formData.append('agreeTerms', this.agreeTerms ? '1' : '0');
    

    if (this.photo) formData.append('photo', this.photo);
    // Si l’utilisateur a téléchargé une photo, on l’ajoute également.
    // Sinon, côté Symfony, on lui attribuera automatiquement "sans_photo.png".

    this.http.post('https://127.0.0.1:8000/api/register', formData).subscribe({
      // On envoie toutes les données du formulaire vers l’API Symfony.
      // Symfony recevra la requête via la route /api/register et créera le nouvel utilisateur.


      next: (res: any) => {
        this.message = res.message;
        this.error = '';
      
      // Petite attente avant redirection
      setTimeout(() => {
        this.router.navigate(['/login']); // vers la page de connexion (/login).
      }, 2000); // 2 secondes
    },
      error: (err) => {
        this.error = err.error.error || 'Erreur inconnue';
        this.message = '';
      }
    });
  }
}