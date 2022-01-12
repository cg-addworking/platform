Feature: Manage enterprise's members

  @create
  Scenario Outline: Can associate a member to an enterprise
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to access to associate's page for "<specific>" enterprise
    Then I "<ability>" be able to pursue this action

    Examples:
      | user    | specific | ability | type |
      | support | an       | should  | any  |

  @create
  Scenario Outline: Associate a member to an enterprise
    Given Im authenticated as "<user>" from "<type>" enterprise
    And This enterprise contains a member with "<email>" as email
    When I try to associate an user with email "<member_email>" to this enterprise
    Then I "<ability>" be able to pursue this action

    Examples:
      | user    | type | email   | member_email | ability    |
      | support | any  | t@t.com | t@t.com      | should not |
      | support | any  | t@t.com | a@a.com      | should     |

  @read
  Scenario Outline: List enterprise's members
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to list all member from "<owner>" enterprise
    Then I "<ability>" be able to pursue this action

    Examples:
      | user                 | owner | ability | type |
      | admin                | my    | should  | any  |
      | support              | an    | should  | any  |
      | operator             | my    | should  | any  |
      | readonly             | my    | should  | any  |
      | signatory            | my    | should  | any  |
      | legal_representative | my    | should  | any  |

  @read
  Scenario Outline: List customer's members for by its vendor
    Given Im authenticated as "<user>" from "<type>" enterprise
      And I have a customer enterprise
     When I try to list all members of customer enterprise
     Then I "<ability>" be able to pursue this action

    Examples:
      | user     | ability    | type   |
      | admin    | should not | vendor |

  @update
  Scenario Outline: Edit enterprise's member
    Given Im authenticated as "<user>" from "<type>" enterprise
    When I try to edit any member from "<owner>" enterprise
    Then I "<ability>" be able to pursue this action

    Examples:
      | user    | owner | ability | type |
      | admin   | my    | should  | any  |
      | support | an    | should  | any  |

  @update
  Scenario Outline: Edit role's member from enterprise
    Given Im authenticated as "<user>" from "<type>" enterprise
    And I select "<specific>" enterprise containing "<number>" more member with "<role>" role
    When I try to remove "<member_role>" role from an "<member>" member
    Then I "<ability>" be able to pursue this action

    Examples:
      | user    | specific | number | role     | member_role | member   | ability    | type |
      | admin   | my       | 1      | all      | admin       | admin    | should     | any  |
      | admin   | my       | 0      | all      | admin       | admin    | should not | any  |
      | support | an       | 0      | admin    | admin       | admin    | should not | any  |
      | support | an       | 2      | all      | readonly    | admin    | should     | any  |

  @delete
  Scenario Outline: Dissociate a member from an enterprise
    Given Im authenticated as "<user>" from "<type>" enterprise
    And I select "<specific>" enterprise containing "<number>" more member with "<role>" role
    When I try to dissociate an "<member>" member from this enterprise
    Then I "<ability>" be able to pursue this action

    Examples:
      | user    | specific | number | role     | member   | ability    | type |
      | admin   | my       | 1      | readonly | readonly | should     | any  |
      | admin   | my       | 1      | operator | admin    | should not | any  |
      | admin   | my       | 0      | readonly | admin    | should not | any  |
      | support | an       | 1      | admin    | admin    | should not | any  |
      | support | an       | 2      | admin    | admin    | should not | any  |
      | support | an       | 2      | operator | operator | should     | any  |
