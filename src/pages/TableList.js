import React, { Component } from 'react';
import Tab from '../components/Tab'
import StatsTable from '../components/StatsTable'

export default class TableList extends Component {
  constructor(props) {
    super(props);

    /** mock up table data  */
    const teams = [
      ['Poradie','Názov tímu','Skóre','Z','V','P','Body','Úspešnosť'],
      [1,'#TYDAMBOJZ', '503:407',  1,5,0,15, '100%'],
      [2,'BALKÁNSKE BANÁNY', '385:350',   4,3,1,9, '75%' ],
      [3,'SOUTH PARK', '396:336',  4,3,1,9, '75%'],
      [4,'BLACK STREET', '363:389',  4,1,3,3, '25%'],
      [5,'4FUN','427:477',  5,1,4,3,  '20%'],
      [6,'BAD BOYZ','271:386',  4,0,4,0, '0%']
    ];

    const players = [
      ['Poradie','Hráč','Tím','Zápasy','Body','Priemer',],
      [1,'Matej Tešliar','BALKÁNSKE BANÁNY',  0,0,0] ,
      [2,'Filip Duda','4FUN',0,0,0 ],
      [3,'Romana Strehlíková','SOUTH PARK',0,0,0 ],
      [4,'Peter Kriller','SOUTH PARK',0,0,0 ],
      [5,'Jakub Tušan','4FUN', 0,0,0 ]
    ];

    const playerTriples = [
      ['Poradie','Hráč','Tím','Zápasy','Body','Priemer',],
      [1,'Peter Kriller','SOUTH PARK',0,0,0 ],
      [2,'Jakub Tušan','4FUN', 0,0,0 ],
      [3,'Romana Strehlíková','SOUTH PARK',0,0,0 ],
      [4,'Matej Tešliar','BALKÁNSKE BANÁNY',  0,0,0] ,
      [5,'Filip Duda','4FUN',0,0,0 ],
    ];

    /**************************************************************************/
    /* End of data mock up
    /**************************************************************************/

    // Navigation tab
    const tabs = [
      { label: 'Poradie tímov', name: 'team-standing', content: teams },
      { label: 'Strelci', name: 'shooters', content: players },
      { label: '3 bodový strelci', name: '3p-shooters', content: playerTriples }
    ];

    this.state = {
      tabs: tabs,
      active: 0,
      content: tabs[0].content,
      label: tabs[0].label
    }
  }

  handleOnClick(item, index) {
    this.setState(() => ({
      active: index,
      content: item.content,
      name: item.name,
      label: item.label
    }));
  }

  render() {

    // Render List of tabs for team and players standing and higlight active one
    const tabList = this.state.tabs.map((item, index) => {
      let isActive = (this.state.active === index ? 'active bg-dark' : '');
      return (
        <Tab active={isActive} name={item} href={item.name} key={index} onClick={this.handleOnClick.bind(this, item, index)} label={item.label} />
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
          <StatsTable data={this.state.content}/>         
        </div>
      </div>
    );
  }
}