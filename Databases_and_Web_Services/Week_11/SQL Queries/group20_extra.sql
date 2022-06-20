
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_details_partners`
--
ALTER TABLE `bank_details_partners`
  ADD CONSTRAINT `bank_details_partners_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `partner_organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_details_users`
--
ALTER TABLE `bank_details_users`
  ADD CONSTRAINT `bank_details_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `donates_to`
--
ALTER TABLE `donates_to`
  ADD CONSTRAINT `donates_to_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `partner_organizations` (`organization_id`),
  ADD CONSTRAINT `donates_to_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `feed_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `partner_organizations` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `fundraisers`
--
ALTER TABLE `fundraisers`
  ADD CONSTRAINT `fundraisers_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `partner_organizations` (`organization_id`) ON DELETE CASCADE;
