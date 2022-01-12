Feature: Manage Legal Form

  @create
  Scenario Outline: Create a legal form
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to create a legal form
    Then I "<ability>" be able to pursue this action

    Examples:
      | user    | type       | ability    |
      | support | addworking | should     |
      | admin   | customer   | should not |

  @create
  Scenario Outline: Store a legal form
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to store a legal form
    Then I "<ability>" be able to pursue this action
    And I "<ability>" see that a new form legal has been created

    Examples:
      | user    | type       | ability    |
      | support | addworking | should     |
      | admin   | customer   | should not |

  @read
  Scenario Outline: List legal forms
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to list all legal form
    Then I "<ability>" be able to pursue this action

    Examples:
      | user    | type       | ability |
      | support | addworking | should  |
