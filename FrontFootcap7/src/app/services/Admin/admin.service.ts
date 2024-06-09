import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

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


  //ELIMINAR CANCHA dependiendo de su ID
  url1= 'http://localhost:8000/';
  public deleteCancha(data:any){
    return this.http.delete(this.url1,data);
  }
}
