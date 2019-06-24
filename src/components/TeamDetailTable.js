import React, { PureComponent } from 'react';


export default class TeamDetailTable extends PureComponent {
  constructor(props) {
    super(props);

    // Navigation tab
    const tabs = [
      { label: 'Zápasy', name: "matches" },
      { label: 'Hráči', name: "players" },
    ];

    this.state = {
      tabs: tabs,
      active: 0,
      name: "matches",
      content: [] , 
      label: tabs[0].label,
    };

  }
  

  handleOnClick(item, index) {
    this.setState(() => ({
      active: index,
      name: item.name,
      label: item.label,
 
    }));

  }
  render() { 
      const tabList = this.state.tabs.map((item, index) => {
        let isActive = (this.state.active === index ? 'active bg-primary text-white' : 'text-primary');
        return (
          <li className="nav-item" key={index} name={index}>
            <span className={`nav-link btn ${isActive} `} name={item.name} onClick={this.handleOnClick.bind(this, item, index)}> {item.label} </span>
          </li>
        )
      })

      return (
        <div className="container">
          <ul className="nav nav-pills mb-3" > {tabList} </ul>
          <div className="card border-dark">
            <div className="card-header text-white bg-primary ">
              {this.state.label}
            </div>
            <div>
              ....content...
            </div>
          </div>
        </div>

    );
  }
}