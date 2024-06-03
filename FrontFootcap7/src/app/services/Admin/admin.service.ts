import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(private http: HttpClient) { }


  //Creacion de Admin
  url=''

  public createAdmin(data:any){
    return this.http.post(this.url,data)
  }
}
