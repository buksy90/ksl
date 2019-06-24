import React, { PureComponent } from 'react';


export default class TeamDetailStatistics extends PureComponent {

  render() { 
    let listOfTeamDetail = this.props.listOfTeamDetail;
    let listOfTeamStatistics = this.props.listOfTeamStatistics;
    
    if(listOfTeamDetail.length === 0 || listOfTeamStatistics.length === 0 ){
        return null;
    }

    var remiza = listOfTeamStatistics.games_played - listOfTeamStatistics.games_won - listOfTeamStatistics.games_lost

   
    return (<div className="">
             <div className="card  border-success">
                <div className="card-header bg-success text-white"> {listOfTeamDetail.name} </div>
                <div className="card-body">
                 <table>
                    <tbody>
                        <tr> 
                         <td className="font-weight-bold">Názov:</td>
                         <td className="pl-2">{listOfTeamDetail.name}</td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Skratka:</td>
                         <td className="pl-2">{listOfTeamDetail.short}</td>
                        </tr>
                        <tr> 
                         <td className="font-weight-bold">Kapitán:</td>
                         <td className="pl-2">{listOfTeamDetail.captain.display_name}
                         </td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Počet hráčov:</td>
                         <td className="pl-2">{listOfTeamDetail.current_roster.length}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
             </div> 
             <div className="card border-primary my-2">
                <div className="card-header bg-primary text-white">Štatistiky</div>
                <div className="card-body">
                  <table>
                    <tbody>
                        <tr> 
                         <td className="font-weight-bold">Odohraté zápasy:</td>
                         <td  className="pl-2">{listOfTeamStatistics.games_played}</td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Výhry:</td>
                         <td className="pl-2">{listOfTeamStatistics.games_won}</td>
                        </tr>
                        <tr> 
                         <td className="font-weight-bold">Prehry:</td>
                         <td className="pl-2">{listOfTeamStatistics.games_lost}</td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Remízy:</td>
                         <td className="pl-2">{remiza}</td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Umiestnenie:</td>
                         <td className="pl-2">{listOfTeamStatistics.standing}</td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Strelené body:</td>
                         <td className="pl-2">{listOfTeamStatistics.points_scored}</td>
                        </tr>
                        <tr> 
                         <td className="font-weight-bold">Strelené body (priemer):</td>
                         <td className="pl-2">{listOfTeamStatistics.points_scored / listOfTeamStatistics.games_played } </td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Inkasované body:</td>
                         <td className="pl-2">{listOfTeamStatistics.points_allowed}</td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Inkasované body (priemer):</td>
                         <td className="pl-2">{listOfTeamStatistics.points_allowed / listOfTeamStatistics.games_played }</td>
                        </tr>
                        <tr>
                         <td className="font-weight-bold">Úspešnosť:</td>
                         <td className="pl-2">{listOfTeamStatistics.success_rate}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
             </div>
           </div>
    );
  }
}