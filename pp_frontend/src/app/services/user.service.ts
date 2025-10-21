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

  getUserById(id: number): Observable<User> {
    return this.http.get<User>(`${this.apiUrl}/${id}`);
  }

  updateUser(id: number, data: Partial<User>): Observable<any> {
    return this.http.put(`${this.apiUrl}/${id}`, data);
  }

  deleteUser(id: number): Observable<any> {
  return this.http.delete(`${this.apiUrl}/${id}`);
}

updateUserWithPhoto(id: number, data: any, photoFile?: File): Observable<any> {
  const formData = new FormData();

  for (const key in data) {
    if (data[key] !== null && data[key] !== undefined) {
      formData.append(key, data[key]);
    }
  }

  if (photoFile) {
    formData.append('photo', photoFile);
  }

  return this.http.post(`${this.apiUrl}/${id}?_method=PUT`, formData);
}

}
