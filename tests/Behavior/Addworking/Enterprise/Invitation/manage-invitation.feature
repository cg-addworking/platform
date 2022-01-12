Feature: Manage Invitation

  @create
  Scenario Outline: Create an invitation
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to create an "<invitation>" invitation
    Then I "<ability>" be able to pursue this action

    Examples:
      | user  | type     | invitation | ability    |
      | admin | vendor   | member     | should     |
      | admin | vendor   | vendor     | should not |
      | admin | customer | any        | should     |


  @invite
  Scenario Outline: Invite specific vendor / member
    Given Im authenticated as "<user>" from "<type>" enterprise
    And This enterprise contains a member with "<email>" as email
    When I try to create a "<invitation>" invitation for "<invite>" email
    Then I "<ability>" be able to pursue this action

    Examples:
      | user  | type     | email   | invitation | invite  | ability    |
      | admin | customer | t@t.com | any        | t@t.com | should not |
      | admin | customer | t@t.com | any        | a@a.com | should     |
      | admin | vendor   | t@t.com | vendor     | a@a.com | should not |
      | admin | vendor   | t@t.com | member     | a@a.com | should     |
      | admin | vendor   | t@t.com | member     | t@t.com | should not |

  @read
  Scenario Outline: List invitation
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to list all invitations from "<own>" enterprise
    Then I "<ability>" be able to pursue this action

    Examples:
      | user  | type | own | ability    |
      | admin | any  | my  | should     |
      | admin | any  | any | should not |

  @delete
  Scenario Outline: Delete an invitation
    Given Im authenticated as "<user>" from "<type>" enterprise
    And I created a "<invitation>" invitation with "<status>" status
    When I try to delete this invitation
    Then I "<ability>" be able to pursue this action

    Examples:
      | user  | type | invitation | ability    | status |
      | admin | any  | member     | should     | any    |
    
  @relaunch
  Scenario Outline: Relaunch an invitation
    Given Im authenticated as "<user>" from "<type>" enterprise
    And I created a "<invitation>" invitation with "<status>" status
    When I try to relaunch this invitation
    Then I "<ability>" be able to pursue this action

    Examples:
      | user  | type | invitation | status      | ability    |
      | admin | any  | member     | accepted    | should not |
      | admin | any  | member     | in_progress | should not |
      | admin | any  | member     | rejected    | should     |
      | admin | any  | member     | pending     | should     |

  @respond
  Scenario Outline: Respond to an invitation
    Given An invitation sent to "<email>"
    When The guest try to "<action>" this invitation
    Then He "<ability>" be able to pursue this action
    And The invitation should be in "<status>" status

    Examples:
      | email   | status      | action   | ability |
      | t@t.com | rejected    | refuse   | should  |
      | t@t.com | pending     | accept   | should  |
      | t@t.com | in_progress | review   | should  |