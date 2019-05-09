import React, { Component } from 'react';
import KslTable from '../components/KslTable';
import providers from '../dataProvider'

export default class TableList extends Component {

  constructor(props) {
    super(props);

    // Navigation tab
    const tabs = [
      { label: 'Poradie tímov', name: "teams" },
      { label: 'Strelci', name: "shooters_2pt" },
      { label: '3 bodový strelci', name: "shooters_3pt" }
    ];

    this.state = {
      tabs: tabs,
      active: 0,
      name: "teams",
      content: [] , //content: this.fetchTeamsData(),
      label: tabs[0].label,
      header:[],
    }
  }
  

    this.fetchTeamsData();
  }
  
  handleOnClick(item, index) {
    this.setState(() => ({
      active: index,
      name: item.name,
      label: item.label,
 
    }));

    if (item.name === "teams") this.fetchTeamsData();
    if (item.name === "shooters_2pt") this.fetch2ptShootersData();
    if (item.name === "shooters_3pt") this.fetch3ptShootersData();

  }

  // Fetch Statistics of each team
  fetchTeamsData() {
    providers.getTeamsStandings().then(data => {
       var dataTeams=data.teams.map(item =>          
            [ item.standing,
              item.name, 
              item.score,
              item.games_played,
              item.games_won, 
              item.games_lost,
              item.points,
              item.success_rate
            ]
          );

        this.setState(() => ({
          content:  dataTeams.sort(),
          header: ["Poradie",  "Tím", "Score", "Odohrané hry", "Výhrý", "Prehry", "Body", "Úspešnosť"]

        }));
      })
      .catch(error => { console.log("Something went wrong " + error); });
  }

  // Fetch Statistics of each player 2-point shot
  fetch2ptShootersData() {
    providers.get2ptShooters().then(data => {
        let dataShooters_2pt = data.shooters_2pt.map(item=> 
          [ item.standing,
            item.player.display_name, 
            item.team.name,
            item.games,
            item.points, 
            item.average,
          ]
        );

      this.setState(() => ({        
          content:  dataShooters_2pt,
          header:  ["Poradie", "Hráč", "Tím", "Zápasy", "Body", "Priemer"],
        }));
      })
      .catch(error => {
        console.log("Something went wrong " + error);
      });
  }

  // Fetch Statistics of each player 3-point shot 
  fetch3ptShootersData() {
    providers.get3ptShooters().then(data => {
        let dataShooters_3pt = data.shooters_3pt.map(item=> 
          [ item.standing,
            item.player.display_name, 
            item.team.name,
            item.games,
            item.points, 
            item.average,
          ]
        );

      this.setState(() => ({      
        content: dataShooters_3pt ,
        header: ["Poradie", "Hráč", "Tím", "Zápasy", "Body", "Priemer"]
      }));
    })
      .catch(error => {
        console.log("Something went wrong " + error);
      });
  }

  render() {

    // Render List of tabs for team and players standing and higlight active one
    const tabList = this.state.tabs.map((item, index) => {
      let isActive = (this.state.active === index ? 'active bg-dark' : '');
      return (
        <li className="nav-item" key={index} name={index}>
          <span className={`nav-link btn ${isActive} text-black`} name={item.name} onClick={this.handleOnClick.bind(this, item, index)} > {item.label} </span>
        </li>
      )
    });

    // Render particular table content
    // Use Bootstrap Card because Bootstrap Panel is not available in Bootstrap v.4

    return (
      <div className="container">
        <h1 className="display-4 border-bottom mb-4 mt-5"> Tabuľky </h1>
        <ul className="nav nav-pills mb-3" > {tabList} </ul>
        <div className="card border-dark">
          <div className="card-header text-white bg-dark ">
            {this.state.label}
          </div>
          <div>
            <KslTable header={this.state.header} data={this.state.content} />
          </div>
        </div>
      </div>
    );
  }
}