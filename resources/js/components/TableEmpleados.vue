<template>
  <div class="container">
    <v-app id="inspire">
      <v-row>
          <v-overlay :value="overlay" :z-index="zIndex">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
                <h6>Cargando informacion</h6>
          </v-overlay>
        <v-col cols="12" md="12">
          <!-- Creacion de nuevo empleado -->
          <v-dialog v-model="modalnewemployee" persistent max-width="600px">
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
                            <v-text-field v-model="name" :rules="[v => !!v || 'El nombre es requerido',v => /^[a-z\a-z\A-Z\_\-\s]+$/.test(v) || 'No se permiten numeros, ni caracteres especiales para su nombre']" label="Nombre *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field v-model="lastnameP" :rules="[v => !!v || 'El apellido paterno es requerido',v => /^[a-z\A-Z\_\-\s]+$/.test(v) || 'No se permiten numeros, ni caracteres especiales para su apellido paterno']" label="Apellido Paterno *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field v-model="lastnameM" :rules="[v => !!v || 'El apellido materno es requerido',v => /^[a-z\A-Z\_\-\s]+$/.test(v) || 'No se permiten numeros, ni caracteres especiales para su apellido materno']" label="Apellido Materno *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-text-field v-model="email" :rules="[() => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(email) || 'Correo con un formato incorrecto']" label="Correo *" outlined required></v-text-field>
                            </v-col>
                            <v-col cols="12">
                            <v-select v-model="typecontrato" :items="['Indefinido', 'Temporal', 'para la formación y el aprendizaje', 'Contrato en prácticas']" :rules="[() => !!typecontrato || 'El tipo de contrato es requerido' ]" label="Tipo de contrato*" outlined required></v-select>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>Los campos marca por un * deven ser llenados</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="modalnewemployee = false">
                    Cancelar
                    </v-btn>
                    <v-btn color="primary" text @click="saveemployenew">
                    Guardar
                    </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>

          <!-- Detalle del empleado -->
          <v-dialog v-model="modaldetail" persistent max-width="600px">
              <v-card>
                  <v-card-title>
                    <span class="text-h5">Detalle de Empleado</span>
                  </v-card-title>
                  <v-card-text>
                      <v-container>
                          <v-row>
                              <v-col cols="12">
                                  <!-- Contenido del modal-->
                                  <p id="p-detail">Codigo: <span id="datosdetail">{{codigodetail}}</span> </p>
                                  <p id="p-detail">Nombre: <span id="datosdetail">{{namedetail}}</span> </p>
                                  <p id="p-detail">Apellido Paterno: <span id="datosdetail">{{lastnamePdetail}}</span> </p>
                                  <p id="p-detail">Apellido Materno: <span id="datosdetail">{{lastnameMdetail}}</span> </p>
                                  <p id="p-detail">Correo Electronico: <span id="datosdetail">{{emaildetail}}</span> </p>
                                  <p id="p-detail">Tipo de contrato: <span id="datosdetail">{{typecontratodetal}}</span> </p>
                                  <p id="p-detail">Estado: <span id="datosdetail">{{statusdetail}}</span> </p>
                              </v-col>
                          </v-row>
                      </v-container>
                  </v-card-text>
                  <v-card-actions>
                      <v-btn color="primary" text @click="modaldetail = false">
                        Aceptar
                      </v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>

          <!-- Editar empleado -->
          <v-dialog v-model="modaledit" persistent max-width="600px">
              <v-card>
                  <v-card-title>
                    <span class="text-h5">Editar Empleado</span>
                  </v-card-title>
                  <v-card-text>
                      <v-container>
                          <v-form ref="formeditt" v-model="validEdit" lazy-validation>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field v-model="nameedit" :rules="[nameedit => !!nameedit || 'El nombre es requerido',nameedit => /^[a-z\A-Z\_\-\s]+$/.test(nameedit) || 'No se permiten numeros, ni caracteres especiales para su nombre']" label="Nombre *" outlined required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="lastnamePedit" :rules="[lp => !!lp || 'El apellido paterno es requerido',lp => /^[a-z\A-Z\_\-\s]+$/.test(lp) || 'No se permiten numeros, ni caracteres especiales para su apellido paterno']" label="Apellido Paterno *" outlined required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="lastnameMedit" :rules="[lm => !!lm || 'El apellido materno es requerido',lm => /^[a-z\A-Z\_\-\s]+$/.test(lm) || 'No se permiten numeros, ni caracteres especiales para su apellido materno']" label="Apellido Materno *" outlined required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="emailedit" :rules="[() => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(emailedit) || 'Correo con un formato incorrecto']" label="Correo *" outlined required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-select v-model="typecontratoedit" :items="['Indefinido', 'Temporal', 'para la formación y el aprendizaje', 'Contrato en prácticas']" :rules="[() => !!typecontratoedit || 'El tipo de contrato es requerido' ]" label="Tipo de contrato*" outlined required></v-select>
                                </v-col>                                
                            </v-row>
                          </v-form>
                      </v-container>
                  </v-card-text>
                  <v-card-actions>
                      <v-btn color="blue darken-1" text @click="modaledit = false">
                        Cancelar
                      </v-btn>
                      <v-btn color="primary" text @click="saveemployeedit">
                        Guardar
                      </v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>

          <!-- Activar empleado -->
          <v-dialog v-model="modalactive" persistent max-width="600px">
              <v-card>
                  <v-card-title>
                    <span class="text-h5">Activar o Desactivar Empleado</span>
                  </v-card-title>
                  <v-card-text>
                      <v-container>
                          <v-row>
                              <v-col cols="12">
                                  <v-switch
                                    v-model="activeemployee"
                                    flat
                                    :label="`El empleado esta ${activeemployeetext}`"
                                    @change="onChangeswitch()"
                                ></v-switch>
                              </v-col>
                          </v-row>
                      </v-container>
                  </v-card-text>
                  <v-card-actions>
                      <v-btn color="blue darken-1" text @click="modalactive = false">
                        Cancelar
                      </v-btn>
                  </v-card-actions>
              </v-card>
          </v-dialog>
        </v-col>

        <v-col cols="12" md="12">
          <v-data-table :headers="headers" class="elevation-1" :items="employeesdatos">
              <template v-slot:item.actionactive="{ item }">
                  <div v-if="item.estado == 'activo'">
                    <v-icon small class="mr-2" @click="fnactiveemployee(item)" id="icon-estatus-activo">
                        mdi-account-check-outline
                    </v-icon>
                  </div>
                  <div v-else>
                    <v-icon small class="mr-2" @click="fnactiveemployee(item)" id="icon-estatus-inactivo">
                        mdi-account
                    </v-icon>
                  </div>
                  
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

<style>
    #p-detail{
        font-size: 150%;
        color:red;
    }
    #datosdetail{
        font-size: 80%;
        color:blue;
    }
    #icon-estatus-activo{
        color:green;
    }
    #icon-estatus-inactivo{
        color:red;
    }
</style>

<script>
    export default {
        data(){
            return {
                overlay: false,
                zIndex: 300,
                typealeert: 'error',
                alertamsm: false,
                msmalert:'',
                headers: [
                    {text: 'Id', value: 'id'},
                    {text: 'Codigo', value: 'codigo'},
                    {text: 'Nombre', value: 'nombre'},
                    {text: 'Apellidos Paterno', value: 'apellidopaterno'},
                    {text: 'Apellido Materno', value: 'apellidomaterno'},
                    {text: 'Correoelectronico', value: 'correoelectronico'},
                    {text: 'Tipocontrato', value: 'tipocontrato'},
                    {text: 'Estado', value:"actionactive"},
                    {text: 'Acciones', value: 'actiondetail'},
                ],
                modalnewemployee: false,
                modaldetail: false,
                modaledit:false,
                modalactive:false,
                employeesdatos: [],
                name:'',
                lastnameP:'',
                lastnameM:'',
                email:'',
                typecontrato:'',
                valid: true,
                // detail datos
                codigodetail:'',
                namedetail:'',
                lastnamePdetail:'',
                lastnameMdetail:'',
                emaildetail:'',
                typecontratodetal:'',
                statusdetail:'',
                // edit datos
                validEdit:true,
                idactive:0,
                idedit:0,
                nameedit:'',
                lastnamePedit:'',
                lastnameMedit:'',
                emailedit:'',
                typecontratoedit:'',
                //active 
                activeemployee: false,
                activeemployeetext: ''
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

                    this.zIndex = 2000;
                    this.overlay = true;
                    axios.post('empleado/add',form).then(response => {
                        if(response.data.code == 200){
                            this.$refs.form.reset();
                            this.modalnewemployee = false;
                            alert( response.data.msm);
                            this.loadingemployees();
                        }
                        this.overlay = false;
                    }).catch((error)=>{
                        this.overlay = false;
                        console.log("-------------------Error en obtener los datos de empleado---------------------");
                        console.log(error);
                    });

                }
            },
            saveemployeedit(){
    
                if(this.$refs.formeditt.validate()){

                    if(this.idedit != 0){
                        var form = new FormData();
                        form.append("id",this.idedit);
                        form.append("name",this.nameedit);
                        form.append("lastnameP",this.lastnamePedit);
                        form.append("lastnameM",this.lastnameMedit);
                        form.append("email",this.emailedit);
                        form.append("typecontrato",this.typecontratoedit); 

                        this.zIndex = 2000;
                        this.overlay = true;
                        axios.post('empleado/update',form).then(response => {
                            if(response.data.code == 200){
                                this.modaledit = false;
                                alert(response.data.msm);
                                this.loadingemployees();
                            }
                            this.overlay = false;
                        }).catch((error)=>{
                            this.overlay = false;
                            console.log("-------------------Error en obtener los datos de empleado---------------------");
                            console.log(error);
                        });
                    } else{
                        alert('Error no se puede modificar ese registro');
                    }                
                }
            },
            fnactiveemployee(empleado){
                this.idactive = empleado.id;
                this.activeemployee = (empleado.estado == 'activo') ? true : false;
                this.activeemployeetext = empleado.estado;
                this.modalactive = true;
            },
            fndetailemploye(empleado){
                this.codigodetail = empleado.codigo;
                this.namedetail = empleado.nombre;
                this.lastnamePdetail = empleado.apellidopaterno;
                this.lastnameMdetail = empleado.apellidomaterno;
                this.emaildetail = empleado.correoelectronico;
                this.typecontratodetal = empleado.tipocontrato;
                this.statusdetail = empleado.estado;
                this.modaldetail = true;
            },
            fneditaremploye(empleado){
                this.idedit = empleado.id;
                this.nameedit= empleado.nombre;
                this.lastnamePedit= empleado.apellidopaterno;
                this.lastnameMedit= empleado.apellidomaterno;
                this.emailedit= empleado.correoelectronico;
                this.typecontratoedit=empleado.tipocontrato;
                this.modaledit = true;
            },
            fndeleteemploye(empleado){

                var eliminar = confirm("Quieres eliminar al empleado: " + empleado.nombre + " " + empleado.apellidopaterno + " " + empleado.apellidomaterno);
                if(eliminar){
                    var form = new FormData();
                    form.append("id",empleado.id);

                        this.zIndex = 2000;
                        this.overlay = true;
                        axios.delete('empleado/delete/' + empleado.id).then(response => {
                            console.log(response.data);
                            if(response.data.code == 200){
                                alert(response.data.msm);
                                this.loadingemployees();
                            }
                            this.overlay = false;
                        }).catch((error)=>{
                            this.overlay = false;
                            console.log("-------------------Error en obtener los datos de empleado---------------------");
                            console.log(error);
                        });
                }
            },
            onChangeswitch(){
                var active = (this.activeemployee == true) ? 'activo' : 'inativo';

                var form = new FormData();
                    form.append("id",this.idactive);
                    form.append("status",active);

                        this.zIndex = 2000;
                        this.overlay = true;
                        axios.post('empleado/active', form).then(response => {

                            if(response.data.code == 200){
                                this.modalactive = false;
                                alert(response.data.msm);
                                this.loadingemployees();
                            }
                            this.overlay = false;
                        }).catch((error)=>{
                            this.overlay = false;
                            console.log("-------------------Error en obtener los datos de empleado---------------------");
                            console.log(error);
                        });

            },
            loadingemployees(){
                axios.get('empleado/get').then(response => {
                    if(response.data.code == 200){
                        this.employeesdatos = response.data.data;
                    }
                }).catch((error)=>{
                    console.log("-------------------Error en obtener los datos de empleado---------------------");
                    console.log(error);
                });
            }
        },
        mounted (){
        this.loadingemployees();  
        }
        
    }
</script>
