#!/bin/bash -e

SED=$(which gsed || which sed)

VERSION_FILE=".version"
CHANGELOG="ChangeLog.md"

check_git_clean () {
  if [[ $(git status --porcelain | wc -l) -gt 0 ]]; then
    echo -e "Working directory not clean; please add/commit, \`make clean\` and/or \`git clean -fdx\`\n"
    git status
    exit 1
  fi
}

expect_yes() {
  if ! [[ "${prompt}" =~ [yY](es)* ]]
  then
    echo "Aborting..."
    return 1
  fi
  return 0
}

check_version () {
  version="$1"
  if ! [[ "${version}" =~ ^v[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$ ]]
  then
      echo -e "\\nThat version does not match semver (vM.m.r)"
      return 1
  else
      return 0
  fi
}

confirm_branch () {
  current_branch=$(git rev-parse --abbrev-ref HEAD)
  read -rp "Do you want to tag the current branch (${current_branch})? <y/N> " prompt
  if ! expect_yes; then
    echo "Please checkout the correct branch and retry."
    exit 1
  fi
}

get_hash () {
  current_hash=$(git rev-parse HEAD)
}

list_last_tags () {
  n_tags=5
  echo "Last ${n_tags} tags:"
  git tag --sort=tag | tail -n $n_tags
}

get_new_version () {
  # Get new version to release
  read -rp "What version do you want to release? " new_version
  while ! check_version "$new_version"; do
      read -rp "New version: " new_version
  done
  check_version "${new_version}"
}

get_prev_version () {
  # Get previous version to generate release notes
  read -rp "What previous version should be used to generate release notes? " prev_version
  while ! check_version "$prev_version"; do
      read -rp "Previous version: " prev_version
  done
}

print_release_notes () {
  # Print release notes
  echo -e "\\nRelease notes: "

  changelog_contents=$(${SED} -n '/Unreleased/,/^## /{/^## /d;p}' "${CHANGELOG}")
  echo -e "${changelog_contents}"
}

confirm_tagging () {
  # prompt to continue
  read -rp "Are you sure you want to update the version and tag? <y/N> " prompt
  expect_yes || exit 1
}

update_version () {
  # update and commit local version file used by tracking telemetry
  echo -e "\\nWriting version file..."
  echo "${new_version}" > "${VERSION_FILE}"

  echo -e "Updating ${CHANGELOG}..."
  ${SED} -i "s/^## \[Unreleased]$/&\n\n## [${new_version}] - $(date +%Y-%m-%d)/" "${CHANGELOG}"

  echo -e "Committing release files..."
  git add "${VERSION_FILE}" "${CHANGELOG}"
  git commit --allow-empty -m "[RELEASE] ${new_version}"
}

create_tag () {
  echo -e "\\nTagging..."
  git tag -a "${new_version}" -m "[RELEASE] ${new_version}" \
    -m "Changes:" -m "${changelog_contents}"
}

confirm_push () {
  # prompt to continue
  read -rp "Are you sure you want to push the new tag? <y/N> " prompt
  if ! expect_yes; then
    revert_tag
    exit 1
  fi
}

push_tag () {
  # push commit and tag
  git push origin "${current_branch}"
  git push origin tag "${new_version}"
}

test_dist() {
  make dist || revert_tag
}

revert_tag() {
  echo -e "\\nReverting tag..."
  git tag -d "${new_version}"
  git reset HEAD^
  exit 1
}

handle_package_manager () {
  # script or instructions to push to package manager
  echo -e "\\nYou should now publish this version to the appropriate package manager"
}

check_git_clean
confirm_branch
get_hash
list_last_tags
get_new_version
get_prev_version
print_release_notes
confirm_tagging
update_version
create_tag
test_dist
confirm_push
push_tag
handle_package_manager
