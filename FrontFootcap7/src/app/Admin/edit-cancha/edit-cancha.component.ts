import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormBuilder, ValidationErrors, ValidatorFn, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AdminService } from 'src/app/services/Admin/admin.service';

@Component({
  selector: 'app-edit-cancha',
  templateUrl: './edit-cancha.component.html',
  styleUrls: ['./edit-cancha.component.css']
})
export class EditCanchaComponent implements OnInit {

  canchaId!: number;
  canchaNombre: string = '';
  formEditCanchas = this.fb.group({
    'nombre': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(5), Validators.maxLength(120)]],
    'localidad': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ /]*$'), Validators.minLength(3), Validators.maxLength(30)]],
    'direccion': ['', [Validators.required, Validators.pattern('^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ ,./]*$'), Validators.minLength(5), Validators.maxLength(255)]], // Permite letras, números y espacios
    'precio': ['', [Validators.required, Validators.min(25), Validators.max(120)]],
    'imagen': ['', [Validators.required, this.imageExtensionValidator()]],
    'disponibilidad': ['', [Validators.required]]
  });

  constructor(
    private route: ActivatedRoute,
    private fb: FormBuilder,
    private adminService: AdminService,
    private router: Router
  ) {}

  // Función validadora de URL de imagen
  imageExtensionValidator(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      const url = control.value;
      if (!url) {
        return null;  // retorna null si no hay valor, es decir, no hay error
      }
      const pattern = /\.(jpg|jpeg|png|gif)$/i;
      const isValid = pattern.test(url);
      return isValid ? null : { invalidExtension: true };  // retorna un error si no es válido
    };
  }

  ngOnInit() {
    this.route.params.subscribe(params => {
      this.canchaId = +params['id']; // Convierte el parámetro a número
      if (this.canchaId) {
        this.adminService.obtenerCancha(this.canchaId).subscribe(
          (data) => {
            this.formEditCanchas.patchValue({
              nombre: data.nombre,
              localidad: data.localidad,
              direccion: data.direccion,
              precio: data.precio,
              imagen: data.imagen,
              disponibilidad: data.disponibilidad
            });
            this.canchaNombre = data.nombre;
          },
          (error) => {
            console.error('Error al cargar los datos de la cancha:', error);
          }
        );
      }
    });
  }

  procesar() {
    if (this.formEditCanchas.valid) {
      if (this.canchaId) {
        this.adminService.editarCancha(this.canchaId, this.formEditCanchas.value).subscribe(
          res => {
            this.router.navigate(['/Canchas']);
          },
          error => {
            console.error('Error al editar la cancha:', error);
          }
        );
      }
    }
  }
}
