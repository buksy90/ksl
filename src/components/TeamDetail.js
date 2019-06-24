import React, { PureComponent } from 'react';
import providers from '../dataProvider';
import TeamDetailStatistics from './TeamDetailStatistics';
import TeamDetailTable from './TeamDetailTable'

export default class TeamDetail extends PureComponent {
    constructor(props) {
        super(props);
        
        this.state = { listOfTeamDetail: [],
                        listOfTeamStatistics: [], 
                    };
         providers.getListOfTeamsDetail().then(data => {
            this.setState({ listOfTeamDetail: data.teams[0] })});
         providers.getListOfTeamsStatistics().then(data => {
            this.setState({ listOfTeamStatistics: data.teams[0] })});
 
    };
  render() { 
   
    return (<div className="container mb-3">
              <div className="border-bottom row mb-5"><h1 className="display-3">{this.state.listOfTeamDetail.name}</h1></div>
              <div className="row ">
                <div className="col-12 col-sm-12 col-md-12 col-lg-4 pl-0 ">
                  <TeamDetailStatistics listOfTeamDetail={this.state.listOfTeamDetail} listOfTeamStatistics={this.state.listOfTeamStatistics}/>
                 </div> 
                <div className="col-12 col-sm-12 col-md-12  col-lg-8 ">
                  <TeamDetailTable />
                </div> 
                </div>
            </div>  
    );
  }
}