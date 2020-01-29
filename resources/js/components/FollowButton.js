import React, { useState } from "react";
import ReactDOM from "react-dom";

const $target = document.getElementById("follow-btn");
const followingInit = $target && +$target.dataset.following;

const FollowButton = () => {
  const [following, setFollowing] = useState(followingInit);

  const handleFollow = async () => {
    try {
      const path = window.location.pathname;
      const userId = path.match(/\d+/)[0];

      let res = await axios(`/profiles/${userId}/follow`);
      if (res.status === 200) {
        setFollowing(!following);

        res = await axios(`/profiles/${userId}/follow/count`);
        if (res.status === 200) {
          buildFollowersLine(res.data);
        }
      }
    } catch (err) {
      console.log(err);
    }
  };

  const buildFollowersLine = data => {
    const $followersLine = document.getElementById("followers-info-line");
    const $followers = document.getElementById("followers-total");
    const { firstFollowersNames, restFollowers, followersTotal } = data;

    if (followersTotal === 0 && $followersLine && $followers) {
      $followersLine.innerHTML = "";
      $followers.innerText = followersTotal;
    }

    if ($followersLine && followersTotal > 0) {
      const prefix = document.createElement("span");
      prefix.innerText = "Followed by ";

      const spans = firstFollowersNames.split(",").map((name, index, array) => {
        const span = document.createElement("span");
        span.setAttribute("class", "font-weight-bold");
        const text = document.createTextNode(name);
        span.appendChild(text);

        if (index !== array.length - 1) {
          /* not last item -> add comma */
          const comma = document.createElement("span");
          comma.setAttribute("class", "font-weight-normal");
          comma.innerText = ", ";
          span.appendChild(comma);
        }
        return span;
      });

      /* altering DOM */
      $followersLine.innerHTML = "";
      $followersLine.appendChild(prefix);
      spans.forEach(span => $followersLine.appendChild(span));
      if (restFollowers > 0) {
        const rest = document.createElement("span");
        rest.innerText = `, and +${restFollowers} more`;
        $followersLine.appendChild(rest);
      }
      if ($followers) {
        $followers.innerText = followersTotal;
      }
    }
  };

  return (
    <button
      type="button"
      className="btn btn-outline-primary btn-sm mt-2"
      onClick={handleFollow}
    >
      {following ? "Unfollow" : "Follow"}
    </button>
  );
};

if ($target) {
  ReactDOM.render(<FollowButton />, $target);
}
