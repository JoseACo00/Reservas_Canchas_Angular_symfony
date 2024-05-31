import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http: HttpClient) { }

  url="http://localhost:8000/login";


  public Login(body:any){

    return  this.http.post(this.url, body);
  }
}
