import { CargardataService } from './../../services/CargarDatos/cargardata.service';
import { Component, OnInit } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Route, Router } from '@angular/router';

@Component({
  selector: 'app-canchas',
  templateUrl: './canchas.component.html',
  styleUrls: ['./canchas.component.css']
})
export class CanchasComponent  implements OnInit{

  canchas: any[] = [];

  constructor(private router: Router, private fb: FormBuilder, private cargarDatos: CargardataService ){
  }


  ngOnInit(): void {
    this.cargarDatos.cargarCanchas().subscribe(data => {
      this.canchas = data;
    }, error => {
      console.error('Error al cargar las canchas', error);
    });
  }





}
