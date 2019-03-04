import React, { PureComponent } from 'react';

export default class Playground extends PureComponent {
    render(){
      return(
        <li className="list-group-item list-group-item-action list-group-item-light">
            <a href={this.props.httpLink} > {this.props.street} </a>
            <span className="float-right"> {this.props.province} </span>
        </li>
      );
    }
}
