import React, { PureComponent } from 'react';

export default class Playground extends PureComponent {
    render() {
        return (
            <li className="list-group-item list-group-item-action list-group-item-light" key={this.props.id}>
                <a href='#playground' > {this.props.name} </a>
                <span className="float-right"> {this.props.district} </span>
            </li>
        );
    }
}

