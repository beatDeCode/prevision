 
    <!-- desglose columas|nombre|active/none|linkedin/dribbble|icono-->
    <div class="container-fluid">
        <div class="row">
            @foreach($botonesWizard as $boton)
                <?php 
                    $botonDesglose=explode('|',$boton);
                ?>
                <div class="col-md-{{$botonDesglose[0]}}">
                    <center>
                    <button type="button" class="btn btn-social-icon-text btn-{{$botonDesglose[3]}}"><i class="typcn {{$botonDesglose[4]}}"></i>{{$botonDesglose[1]}}</button>
                    </center>
                    <div class="container-fluid">
                    <hr class="hr-{{$botonDesglose[2]}}">
                    </div>
                </div>
            @endforeach
        <?php 
        $barraProgresiva= explode('|',$barra[0]);
        ?>
        <!-- desglose porcentaje|color -->
            <div class="col-md-3">
                <div class="template-demo">
                    <div class="d-flex justify-content-between mt-2" style="font-size:16px">
                    <small>Porcentaje de Proceso </small>
                    <small>{{$barraProgresiva[0]}}%</small>
                    </div>
                    <div class="progress progress-sm mt-2">
                    
                        <div class="progress-bar bg-{{$barraProgresiva[1]}}" role="progressbar" style="width: {{$barraProgresiva[0]}}%" aria-valuenow="{{$barraProgresiva[0]}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

        
        </div>
    </div>

   