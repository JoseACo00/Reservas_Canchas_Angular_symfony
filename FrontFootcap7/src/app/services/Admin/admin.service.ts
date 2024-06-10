import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(private http: HttpClient) { }

  //Creacion de Admin
  url= 'http://localhost:8000/registrarAdmin';
  public createAdmin(data:any){
    return this.http.post(this.url,data)
  }


  //Crear Canchas
  addcancha= 'http://localhost:8000/registrarCancha';
  public addCancha(data:any){
    return this.http.post(this.addcancha,data)
  }

   // Obtener detalles de una cancha por su ID
   obtenerCancha(canchaId: number): Observable<any> {
    const url = `http://localhost:8000/cancha/${canchaId}`;
    return this.http.get<any>(url);
  }

  // Editar una cancha
  editarCancha(canchaId: number, data: any): Observable<any> {
    const url = `http://localhost:8000/cancha/${canchaId}/edit`;
    return this.http.put(url, data);
  }



}
