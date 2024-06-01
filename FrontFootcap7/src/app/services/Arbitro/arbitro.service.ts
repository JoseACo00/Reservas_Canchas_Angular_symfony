import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ArbitroService {

  constructor(private htttp: HttpClient) { }


  url= 'http://localhost:8000/registroArbitro';

  public registarArbitro(data:any) {
    
    return this.htttp.post(this.url,data);
  }

}
