import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CargardataService {

  constructor(private http:HttpClient) { }

  //1 CARGAR DATOS DE LA TABLA CANCHA

  url= 'http://localhost:8000/cargarCanchas';

  public cargarCanchas(): Observable<any> {
    return this.http.get<any>(this.url);
  }
}
