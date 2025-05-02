<link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo date('His')?>">
<h4 class="text-blue">Listado de Solicitudes Propias de Cheques</h4>
<?php 
$iscorreo = FALSE;
if(!empty($perfil)){
    $iscorreo = stripos($perfil->email, '@impressa.com');
    $iscorreo = !empty($iscorreo);
}
?>
<form role="form" id="frmCrearSolc" name="frmCrearSolc"  class="form-inline" method="post" action="json.php?c=solcheque&a=agregar_cheque">
    <table class="table table-condensed">	
        <thead>
            <tr>
                <td bgcolor="#f5f5f5" colspan="3"><b>Creación de Solicitud</b></td>
            </tr>
        </thead>
        <tbody class="text-input">
            <tr>
                <td>Seleccione Empresa</td>
                <td colspan="2">
                    <input type="hidden" name="borrador" value=""/>
                    <select class="form-control input-sm" id="id_empresa" name="id_empresa">
                        <?php if(!empty($perfil)): ?>
                            <?php if(!empty($perfil->empresa)): ?>
                                <?php if(count($perfil->empresa) > 1): ?>
                                    <option value="">-- Seleccione Empresa --</option>
                                <?php endif; ?>
                                <?php foreach ($perfil->empresa as $emp): ?>
                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->nombre; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </td>
                <td class="valid_empresa"></td>
            </tr>
        <tr>
            <td>Centro de Costo</td>
            <td>
                <div class="form-group">
                    <label id="centros" class="control-label">
                        <select class="form-control input-sm" id="id_cc" name="id_cc">
                            <option> -- Centros de Costo -- </option>
                        </select>
                    </label>
                </div>
            </td>
            <td class="valid_cc"></td>
        </tr>
        <tr>
            <td>Emitir cheque a nombre de</td>
            <td>
                <div class="form-group">
                    <input autocomplete="off" type="text" name="nombre_beneficiario" id="nombre_beneficiario" maxlength="67" placeholder="Nombre beneficiario" class="form-control input-sm"/>
                </div>
            </td>
            <td class="valid_nombre"></td>
        </tr>
        <tr>
            <td>
			Monto del cheque &nbsp;
                <select name="moneda">
                    <option value="$">Moneda $</option>
                </select>
			</td>
            <td>
                <div class="form-group">
                    <input autocomplete="off" type="text" name="valor_cheque" id="valor_cheque" placeholder="Monto del cheque" class="form-control input-sm"/>
                </div>
            </td>
            <td class="valid_monto"></td>
        </tr>
        <tr>
            <td>Concepto del pago</td>
            <td>
                <div class="form-group">
                    <textarea autocomplete="off" name="concepto_pago" id="concepto_pago" maxlength="120" placeholder="Concepto del pago" class="form-control input-sm"></textarea>
                </div>
            </td>
            <td class="valid_concepto"></td>
        </tr>
        <tr>
            <td>Fecha Máx. de pago</td>
            <td>
                <div class="form-group">
                    <input autocomplete="off" type="text" name="fecha_max_pago" id="fecha_max_pago" placeholder="Fecha máx. de pago" class="form-control input-sm"/>
                </div>
            </td>
            <td class="valid_fecha"></td>
        </tr>
        <tr style="display: none;">
            <td>Negociable</td>
            <td>
                <div class="form-group">
                    <input type="checkbox" name="negociable" id="negociable" value="1" />
                </div>
            </td>
        </tr>
        <tr>
            <td>Observación</td>
            <td>
                <div class="form-group">
                    <textarea autocomplete="off" name="observacion" id="observacion" maxlength="120" placeholder="Observación" class="form-control input-sm"></textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td>Adjunto (.pdf, .xlsx, .xls, .docx, .png, .jpeg, .jpg), tamaño máximo 2MB.</td>
            <td>
                <div class="form-group">
                    <input type="file" name="file" style="display: none;" id="file" accept=".pdf,.xlsx,.xls,.docx,.png,.jpeg,.jpg,.gif" />
                    <a class="btn btn-default btn-upload" href="#">
                        Seleccionar archivo
                        <i class="glyphicon glyphicon-upload"></i>
                    </a>
                </div>
            </td>
            <td class="file_info"></td>
        </tr>
        <tr>
            <?php if($iscorreo):?>
            <td></td>
            <td>
                <div class="form-group">
                    <!--<button class="btn btn-sm btn-primary" data-create="S" type="submit" title="Crea solicitud sin enviar para autorización">
                        <i class="glyphicon glyphicon-plus"></i> Crear
                    </button>-->
                    <button class="btn btn-sm btn-success" data-create="N" type="submit" title="Crea y envía solicitud para autorización">
                        <i class="glyphicon glyphicon-plus"></i> Crear y Enviar
                        <i class="glyphicon glyphicon-envelope"></i>
                    </button>
                    <span class='msj_error'></span>
                </div>
            </td>
            <td></td>
            <?php else: ?>
            <td colspan="2">
            <div class="alert alert-danger" role="alert">
                <i class="glyphicon glyphicon-warning-sign" style="font-size:20px;"></i>
                No es posible crear solicitud de cheque, la cuenta de usuario no tiene asignado correo interno.
            </div>
            </td>
            <?php endif; ?>
        </tr>
        </tbody>
	</table>
</form>


<div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h2 class="info_create"></h2>
				<center>
					<a href="?c=solcheque&a=consultar" class="btn btn-default">
						<i class="glyphicon glyphicon-search"></i> 
						Consultar Solicitud
					</a>
					<a class="btn btn-primary" href="?c=solcheque&a=crear">
						<i class="glyphicon glyphicon-pencil"></i> 
						Crear otra solicitud
					</a>
				</center>
			</div>
		</div>
	</div>
</div>

<div class="loading">
    <div>
        <img src="public/load.gif"/>
        <label>Procesando...</label>
    </div>
</div>

<script type="text/javascript" src="js/file.js?v=<?php echo date('His')?>"></script>
<script type="text/javascript" src="js/js.js?v=<?php echo date('His')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){

            $('[name=fecha_max_pago]').datepicker({format: 'dd/mm/yyyy'}).on('changeDate', function(e){
                $(this).datepicker('hide');
            });
            $('#modalConfirmar').on('hidden.bs.modal', function (e) {
                window.location.replace('?c=solcheque&a=crear');
                return false;
            });
            $('[name=fecha_max_pago]').keypress(function(e){
                return (e.keyCode!=13);
            });
            var formsol=$('form#frmCrearSolc');
            var inp_empresa=$('[name=id_empresa]');
            var inp_cc = $('[name=id_cc]');

            var pjson={
                    msj: function(text){
                            $('.msj_error').text(text);
                    },
                    empresa_cc: function(){
                            if(inp_empresa.val()!==''){
                                    var request=request_json_id({
                                            id: inp_empresa.val(),
                                            action: 'json.php?c=solcheque&a=json_cc_empresa',
                                            method: formsol.attr('method')
                                    });
                                    if(request!==undefined){
                                            inp_cc.html('');
                                            $.each(request.cc, function(i, item){
                                                    inp_cc.append("<option value='" + item.id_cc + "'>" + item.cc_descripcion + "</option>");
                                            });
                                            //$('.viewn3').show();
                                    }else{
                                            inp_cc.append("<option value=''>--Centros de Costo--</option>");	
                                    }
                            }else{
                                    inp_cc.html('');
                                    inp_cc.append("<option value=''>--Centros de Costo--</option>");	
                            }
                    },
                    clear: function(){
                            $('[name=nombre_beneficiario]').val('');
                            $('[name=valor_cheque]').val('');
                            $('[name=concepto_pago]').val('');
                            $('[name=fecha_max_pago]').val('');
                            $('[name=negociable]').prop('checked',false);
                            $('[name=observacion]').val('');
                            $('[name=file]').val('');
                            $('.file_info').text('');
                    },
                    isValid: function(){
                        var error=false;
                        if($('[name=id_empresa]').val()===''){
                            $('.valid_empresa').text('Seleccionar Empresa.');
                            error=true;
                        }
                        if($('[name=id_cc]').val()===''){
                            $('.valid_cc').text('Seleccionar Centro de Costo.');
                            error=true;
                        }
                        if($('[name=nombre_beneficiario]').val()===''){
                            $('.valid_nombre').text('Ingresar nombre beneficiario.');
                            error=true;
                        }
                        if($('[name=valor_cheque]').val()==='' || isNaN($('[name=valor_cheque]').val())){
                            $('.valid_monto').text('Ingresar monto del cheque.');
                            error=true;
                        }
                        if($('[name=concepto_pago]').val()===''){
                            $('.valid_concepto').text('Ingresar concepto del pago.');
                            error=true;
                        }
                        if($('[name=fecha_max_pago]').val()===''){
                            $('.valid_fecha').text('Ingresar fecha máx. de pago.');
                            error=true;
                        }
                        return !error;
                    }
            };
            pjson.empresa_cc(); // carga centro de costo asignados a la empresa
            $('.btn-upload').click(function(){
                    $('[name=file]').click();
                    return false;
            });
            $('[name=file]').change(function(){
                    var path_file=$(this).val();
                    pjson.msj('');
                    if(path_file!==undefined){
                        if(path_file!==''){
                            $('.file_info').text('');
                            if(!file.validar(path_file)){
                                $(this).val('');
                                $('.file_info').text('Formato incorrecto');
                            }else{
                                $('.file_info').text(file.name(path_file));
                            }
                        }
                    }
            });
            inp_empresa.change(function(){
                pjson.empresa_cc();
            });
            $('[type=submit]').click(function(){
                $('[name=borrador]').val($(this).attr('data-create'));
                $('.text-input tr td:nth-child(3):not(.file_info)').text('');
            });
            formsol.submit(function(e){
                e.preventDefault();
                $('.loading').css({display:'block'});  
                $('[type=submit]').attr('disabled','disabled');
                pjson.msj('');  
                if(pjson.isValid()){
                    var request=request_json(this);
                    if(request!==undefined){
                        if(request.exito){
                            request_json_email({
                                id: parseInt(request.msj)
                            });
                            $('.info_create').text('Se ha creado solicitud No ' + request.msj);
                            $('#modalConfirmar').modal('show');
                        }else{
                            if(request.msj!==null){
                                pjson.msj(request.msj);
                            }else{
                                pjson.msj('Error: verificar formato y tamaño de archivo adjunto.');
                            }
                        }
                    }
                }
                $('.loading').hide();
                $('[type=submit]').removeAttr('disabled');
                return false;
            });
            //$('.loading').show();
			var empresa_id = $('[name=id_empresa]');
            var moneda = $('[name=moneda]');
            empresa_id.change(function(){
                set_moneda($(this).val());
            });
            set_moneda(empresa_id.val());
            function set_moneda(empr){
                if(empr=='6' || empr=='8'){
                    moneda.html('');
                    if(empr=='6'){
                        moneda.append("<option value='L'>Moneda L</option>");
                    }else{
                        moneda.append("<option value='C$'>Moneda C$</option>");
                    }
                    moneda.append("<option value='$'>Moneda $</option>");
                }else{
                    moneda.html('');
                    moneda.append("<option value='$'>Moneda $</option>");
                }
            }
	});
</script>
