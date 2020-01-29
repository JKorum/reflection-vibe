import React, { Fragment } from "react";
import ReactDOM from "react-dom";

const $target = document.getElementById("profile-info-section");
const posts = $target && $target.dataset.postsCount;
const followers = $target && $target.dataset.profileFollowersCount;
const following = $target && $target.dataset.profileFollowingCount;
const firstFollowersNames = $target && $target.dataset.firstFollowersNames;
const restFollowers = $target && +$target.dataset.restFollowers;

const ProfileInfo = () => {
  return (
    <Fragment>
      <div className="row pb-2">
        <div className="col">
          <small id="followers-info-line">
            {followers > 0 ? (
              <Fragment>
                Followed by{" "}
                {firstFollowersNames.split(",").map((name, index, array) => {
                  if (index === array.length - 1) {
                    return (
                      <span key={index} className="font-weight-bold">
                        {name}
                      </span>
                    );
                  } else {
                    return (
                      <span key={index} className="font-weight-bold">
                        {name}
                        <span className="font-weight-normal">, </span>
                      </span>
                    );
                  }
                })}
                {restFollowers > 0 ? (
                  <span className="text-muted">
                    , and +{restFollowers} more
                  </span>
                ) : null}
              </Fragment>
            ) : null}
          </small>
        </div>
      </div>
      <div className="row border-top border-bottom p-2">
        <div className="col-4 text-center">
          <p className="m-0 font-weight-bold">{posts}</p>
          <p className="m-0 text-muted">posts</p>
        </div>
        <div className="col-4 text-center">
          <p id="followers-total" className="m-0 font-weight-bold">
            {followers}
          </p>
          <p className="m-0 text-muted">followers</p>
        </div>
        <div className="col-4 text-center">
          <p className="m-0 font-weight-bold">{following}</p>
          <p className="m-0 text-muted">following</p>
        </div>
      </div>
    </Fragment>
  );
};

if ($target) {
  ReactDOM.render(<ProfileInfo />, $target);
}
