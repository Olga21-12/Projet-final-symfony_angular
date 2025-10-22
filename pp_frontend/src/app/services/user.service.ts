import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from '../models/user';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  private apiUrl = 'https://127.0.0.1:8000/api/users';

  constructor(private http: HttpClient) {}

  // Obtenir tous les utilisateurs
  getAllUsers(): Observable<User[]> {
    return this.http.get<User[]>(this.apiUrl);
  }

  //Obtenir l'utilisateur par ID
  getUserById(id: number): Observable<User> {
    return this.http.get<User>(`${this.apiUrl}/${id}`);
  }

  // Mettre à jour le profil sans photo (JSON pur)
  updateUser(id: number, data: Partial<User>): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, data);
  }

  deleteUser(id: number): Observable<any> {
  return this.http.delete(`${this.apiUrl}/${id}`);
}

  //Mettre à jour votre profil avec une photo avec FormData
  updateUserWithPhoto(id: number, data: any, photoFile?: File): Observable<any> {
    const formData = new FormData();

    // Ajouter tous les champs
    formData.append('nom', data.nom || '');
    formData.append('prenom', data.prenom || '');
    formData.append('surnom', data.surnom || '');
    formData.append('adresse', data.adresse || '');
    formData.append('telephone', data.telephone || '');
    formData.append('role', data.role || '');
    formData.append('pays', data.pays || '');
    formData.append('ville', data.ville || '');
    formData.append('date_naissance', data.date_naissance || '');

    if (photoFile) {
      formData.append('photo', photoFile);
    }

    return this.http.post(`${this.apiUrl}/${id}?_method=PUT`, formData);
  }

}
