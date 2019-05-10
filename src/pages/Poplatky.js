import React, { Component } from 'react';

export default class Poplatky extends Component {
    render() {
     return (
      <div class="container">

        <div class="row"> 
          <div className="row">
            <div className="col-12 pb-2 mt-4 mb-2">
               <h1>Pokuty a poplatky</h1>
            </div>
         </div>
       </div> 

       <div class="row form-group">
        <div class="col-12">  
          <table class="table table-striped table-hover">
              <thead>
                  <tr>
                      <th>Názov položky</th>
                      <th>Cena</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>Štartovné za družstvo</td>
                      <td>40 €</td>
                  </tr>
                  <tr>
                      <td>Štartovné za jedného hráča družstva</td>
                      <td>5 €</td>
                  </tr>
                  <tr>
                      <td>Družstvo nenastúpilo v zápase s jednotnými dresmi</td>
                      <td>15 €</td>
                  </tr>
                  <tr>
                      <td>Neuznanie protestu družstva</td>
                      <td>15 €</td>
                  </tr>
                  <tr>
                      <td>Neoprávnený štart hráča</td>
                      <td>10 €</td>
                  </tr>
                  <tr>
                      <td>Neskoré nahlásenie predohrávky, dohrávky</td>
                      <td>10 €</td>
                  </tr>
                  <tr>
                      <td>Kontumácia zápasu</td>
                      <td>20 €</td>
                  </tr>
                  <tr>
                      <td>Každé vylúčenie hráča v zápase (platí hráč)</td>
                      <td>5 €</td>
                  </tr>
                  <tr>
                      <td>Poplatok za doplnenie hráča na súpisku do polovice základnej časti</td>
                      <td>5 €</td>
                  </tr>
              </tbody>
           </table>   
         </div>
        </div>

       </div>
    );
    }
  }