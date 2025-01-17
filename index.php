<!doctype html>
<html lang="es">

<head>
  <title>Administración de categorías</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container">
    <ul class="nav mt-2">
      <li class="nav-item">
        <a class="nav-link" href="#">Facturación</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Administración</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="categorias/administracion.html">Mantenimiento de categorías</a>
          <a class="dropdown-item" href="productos/administracion.html">Mantenimiento de productos</a>
          <a class="dropdown-item" href="clientes/administracion.html">Mantenimiento de clientes</a>
        </div>
      </li>
    </ul>

    <?php
    require("conexion.php");
    $pdo = retornarConexion();
    $sql = $pdo->prepare(
      "select 
              fact.codigo as codigo,
              date_format(fecha,'%d/%m/%Y') as fecha,
              nombre,
              round(sum(deta.precio*deta.cantidad),2) as importefactura
          from facturas as fact 
          join clientes as cli on cli.codigo=fact.codigocliente
          join detallefactura as deta on deta.codigofactura=fact.codigo
          group by deta.codigofactura
          order by codigo desc"
    );
    $sql->execute();
    $filas = $sql->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h1>Facturas emitidas</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Factura</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th class="text-right">Importe</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($filas as $fila) {
          ?>
          <tr>
            <td><?php echo $fila['codigo'] ?></td>
            <td><?php echo $fila['nombre'] ?></td>
            <td><?php echo $fila['fecha'] ?></td>
            <td class="text-right"><?php echo '$' . number_format($fila['importefactura'], 2, ',', '.'); ?></td>
            <td class="text-right">
              <a class="btn btn-primary btn-sm botonimprimir" role="button" href="#" data-codigo="<?php echo $fila['codigo'] ?>">Imprime?</a>
              <a class="btn btn-primary btn-sm botonborrar" role="button" href="#" data-codigo="<?php echo $fila['codigo'] ?>">Borra?</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <button type="button" id="btnNuevaFactura" class="btn btn-success">Emitir factura</button>
  </div>

  <!-- ModalConfirmarBorrar -->
  <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 600px" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h1>¿Realmente quiere borrar la factura?</h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmarBorrado" class="btn btn-success">Confirmar</button>
          <button type="button" data-dismiss="modal" class="btn btn-success">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      $('#btnNuevaFactura').click(function() {
        window.location = 'facturacion.php';
      });

      var codigofactura;

      $('.botonborrar').click(function() {
        codigofactura = $(this).get(0).dataset.codigo;
        $("#ModalConfirmarBorrar").modal();
      });

      $('#btnConfirmarBorrado').click(function() {
        window.location = 'borrarfactura.php?codigofactura=' + codigofactura;
      });

      $('.botonimprimir').click(function() {
        window.open('pdffactura.php?' + '&codigofactura=' + $(this).get(0).dataset.codigo, '_blank');
      });

    });
  </script>

</body>

</html>