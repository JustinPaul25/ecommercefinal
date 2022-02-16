<!DOCTYPE html>
<html>

<head>

</head>

<style>
    .page-header, .page-header-space {
  height: 100px;
}

.page-footer, .page-footer-space {
  height: 50px;

}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
  border-top: 1px solid black; /* for demo */
  background: yellow; /* for demo */
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  border-bottom: 1px solid black; /* for demo */
  background: yellow; /* for demo */
}

.page {
  page-break-after: always;
}

.table-items {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.td-items, .th-items {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 4px;
}

.tr-items:nth-child(even) {
  background-color: #dddddd;
}

@page {
  margin: 20mm
}

@media print {
   thead {display: table-header-group;} 
   tfoot {display: table-footer-group;}
   
   button {display: none;}
   
   body {margin: 0;}
}
</style>

<body>
  <div class="page-header" style="text-align: center">
    Ming Computer Solutions<br/>
    Panabo Branch<br/>
    Income Statement Date
    <br/>
    <button type="button" onClick="window.print()" style="background: pink">
      PRINT ME!
    </button>
  </div>

  <div class="page-footer">
    Ming Computer Solutions
  </div>

  <table>

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>
          <!--*** CONTENT GOES HERE ***-->
          <div class="page" style="line-height: 3;">
            <table class="table-items">
                <tr class='tr-items'>
                  <th class="th-items">Cart Id</th>
                  <th class="th-items">Product</th>
                  <th class="th-items">Quantity</th>
                  <th class="th-items">Price</th>
                  <th class="th-items"></th>
                </tr>
                <tr class='tr-items'>
                  <td class="td-items">Alfreds Futterkiste</td>
                  <td class="td-items">Maria Anders</td>
                  <td class="td-items">Germany</td>
                  <td class="td-items">Germany</td>
                  <td class="td-items">Germany</td>
                </tr>
              </table>
          </div>
        </td>
      </tr>
    </tbody>

    <tfoot>
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space"></div>
        </td>
      </tr>
    </tfoot>

  </table>

</body>

</html>