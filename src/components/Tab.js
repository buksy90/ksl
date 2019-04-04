import React, { PureComponent } from 'react';

export default class Tab extends PureComponent {

  render() {
    return (
      <li className="nav-item">
        <a className={`nav-link ${this.props.active} text-black` } href={`#${this.props.href}`} key={`${this.props.index}`} onClick={this.props.onClick} role="button" > {this.props.label} </a>
      </li>
    )
  }
}