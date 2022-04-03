<template>
  <div class="container">
    <v-app id="inspire">
      <v-row>
        <v-col cols="12" md="12">
          <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="#3700ff" dark v-bind="attrs" v-on="on">
                Nuevo Empleado
              </v-btn>
            </template>
            <v-card>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-title>
                    <span class="text-h5">Empleado nuevo</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                            <v-text-field v-model="name" :rules="[() => !!name || 'Este valor es requerido']" label="Nombre *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field v-model="lastnameP" :rules="[() => !!lastnameP || 'Este valor es requerido']" label="Apellido Paterno *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field v-model="lastnameM" :rules="[() => !!lastnameM || 'Este valor es requerido']" label="Apellido Materno *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field v-model="email" :rules="[() => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email) || 'Correo con un formato incorrecto']" label="Correo *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-select v-model="typecontrato" :items="['Indefinido', 'Temporal', 'para la formación y el aprendizaje', 'Contrato en prácticas']" :rules="[() => !!typecontrato || 'Este valor es requerido' ]" label="Tipo de contrato*" outlined required></v-select>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>Los campos marca por un * deven ser llenados</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">
                    Cancelar
                    </v-btn>
                    <v-btn color="primary" text @click="saveemployenew">
                    Guardar
                    </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
        </v-col>

        <v-col cols="12" md="12">
          <v-data-table :headers="headers" class="elevation-1" :items="employeesdatos">
              <template v-slot:item.actionactive="{ item }">
                  <v-checkbox v-model="employeeactive" @click="fnactiveemployee(item)"></v-checkbox>
              </template>

                  
              <template v-slot:item.actiondetail="{ item }">
                  <v-icon small class="mr-2" @click="fndetailemploye(item)">
                    mdi-account
                  </v-icon>

                  <v-icon small @click="fneditaremploye(item)">
                    mdi-pencil
                  </v-icon>

                  <v-icon small @click="fndeleteemploye(item)">
                    mdi-delete
                  </v-icon>

              </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-app>
  </div>
</template>

<style></style>

<script>
export default {
     data(){
         return {
             headers: [
                {text: 'Id', value: 'id'},
                {text: 'Codigo', value: 'codigo'},
                {text: 'Nombre', value: 'nombre'},
                {text: 'Apellidos Paterno', value: 'apellidopaterno'},
                {text: 'Apellido Materno', value: 'apellidomaterno'},
                {text: 'Correoelectronico', value: 'correoelectronico'},
                {text: 'Tipocontrato', value: 'tipocontrato'},
                {text: 'Estado', value: 'estado'},
                {text: 'Activar', value:"actionactive"},
                {text: 'Acciones', value: 'actiondetail'},
            ],
            dialog: false,
            employeesdatos: [],
            name:'',
            lastnameP:'',
            lastnameM:'',
            email:'',
            typecontrato:'',
            valid: true,
            employeeactive:true
         }
     },
     methods:{
         saveemployenew(){
             if(this.$refs.form.validate()){
                
                var form = new FormData();
                form.append("name",this.name);
                form.append("lastnameP",this.lastnameP);
                form.append("lastnameM",this.lastnameM);
                form.append("email",this.email);
                form.append("typecontrato",this.typecontrato);  
                
                console.log("-------------------erl----------------------");
                console.log(form);
             }
         },
         fnactiveemployee(empleado){
             console.log("-------------------------Empleado activando----------------------");
             console.log(empleado);
         },
         fndetailemploye(empleado){
             console.log("-------------------------Empleado detalle----------------------");
             console.log(empleado);
         },
         fneditaremploye(empleado){
             console.log("-------------------------Empleado editar----------------------");
             console.log(empleado);
         },
         fndeleteemploye(empleado){
             console.log("-------------------------Empleado activar----------------------");
             console.log(empleado);
         }
     },
     mounted (){
         axios.get('empleado/get').then(response => {
             if(response.data.code == 200){
                 this.employeesdatos = response.data.data;
             }
         }).catch((error)=>{
             console.log("-------------------Error en obtener los datos de empleado---------------------");
             console.log(error);
         });
     }
     
}
</script>
