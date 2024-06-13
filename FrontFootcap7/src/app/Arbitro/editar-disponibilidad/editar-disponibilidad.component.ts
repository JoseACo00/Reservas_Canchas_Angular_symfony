import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { ArbitroService } from 'src/app/services/Arbitro/arbitro.service';
import { LoginService } from 'src/app/services/Loggin/login.service';

@Component({
  selector: 'app-editar-disponibilidad',
  templateUrl: './editar-disponibilidad.component.html',
  styleUrls: ['./editar-disponibilidad.component.css']
})
export class EditarDisponibilidadComponent {
  arbitroId!: number;
  arbitroName: string = '';
  arbitroSurname: string = '';
  formEditArbitro: FormGroup;

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private arbitroService: ArbitroService,
    private router: Router,
    private loginService: LoginService
  ) {
    this.formEditArbitro = this.fb.group({
      experiences: ['', [Validators.required]],
      disponibilidad: ['', [Validators.required]]
    });
  }

  ngOnInit(): void {
    this.arbitroId = this.loginService.getUserId()!;
    this.cargarDatosArbitro();
  }

  cargarDatosArbitro(): void {
    this.arbitroService.obtenerArbitro(this.arbitroId).subscribe(
      data => {
        this.arbitroName = data.name;
        this.arbitroSurname = data.surname1;
        this.formEditArbitro.patchValue({
          name: data.name,
          surname1: data.surname1,
          experiences: data.experiences,
          disponibilidad: data.disponibilidad
        });
      },
      error => {
        console.error('Error al cargar los datos del árbitro:', error);
      }
    );
  }

  procesar(): void {
    if (this.formEditArbitro.valid) {
      const formData = this.formEditArbitro.value;
      this.arbitroService.editarArbitro(this.arbitroId, formData).subscribe(
        res => {
          console.log('Datos actualizados:', res);
          this.router.navigate(['/Arbitro/partidos']);
        },
        error => {
          console.error('Error al actualizar los datos del árbitro:', error);
        }
      );
    } else {
      console.error('Formulario no válido');
    }
  }
}
