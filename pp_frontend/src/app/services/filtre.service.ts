import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Bien } from './bien.service';

@Injectable({
  providedIn: 'root'
})
export class FiltreService {
  private apiUrl = 'https://localhost:8000/api/biens/filtre';

  constructor(private http: HttpClient) {}

  search(filters: any): Observable<Bien[]> {
    const params = new HttpParams({ fromObject: filters });
    return this.http.get<Bien[]>(this.apiUrl, { params });
  }
}
